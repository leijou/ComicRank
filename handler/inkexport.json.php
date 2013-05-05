<?php
namespace ComicRank;

$page = new Serve\JSON;

if ( (!isset($_GET['email'])) || (!isset($_GET['password'])) ) {
    $page->exitDisplay(404, array('error'=>'Credentials missing'));
}

$user = Model\User::getFromEmail($_GET['email']);
if ( (!$user) || (!$user->verifyPassword($_GET['password'])) ) {
    $page->exitDisplay(403, array('error'=>'Invalid credentials'));
}

if ( ($user->id != 'ink1') && (!$user->admin) ) {
    $page->exitDisplay(403, array('error'=>'Not Authorized'));
}

$page->outputHeaders();

echo '{';
$first = true;
$s = Database::query('SELECT * FROM comics WHERE inkid != ""');
while ($comic = Model\Comic::getNextFromStatement($s)) {
    if (!$first) echo ',';
    $first = false;
    echo json_encode($comic->id).':'.json_encode(['inkid'=>$comic->inkid, 'readers'=>$comic->readers('int')]);
}
echo '}';
