<?php
require_once('./config.php');



const PIDMIN = 1000000000;
const PIDMAX = 9999999999;
const UIDMIN = 10000000;
const UIDMAX = 99999999;
//namespace sdb;

function MakeSalt($length = 12){
  return base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
}


//MichiShareObject
class MSO{
  private $pdo, $error, $error_info;
  private $post_num, $fetch_tmp;
  public function __construct(){
    $this -> error = "";
    $this -> pdo = new PDO(DSN, DBUSER, DBPSWD);
    $sth = $this -> pdo -> query("select count(*) from post");
    $this -> post_num = $sth -> fetchColumn();
  }

  private function inputCheck( ...$arg){
    $rtn = 0b0;
    if(count($arg) >= 60) return ~$rtn;
    for($i = 0; $i < count($arg); $i++){
      if(!($arg[$i])) $rtn |= (1 << $i);
    }
    return $rtn;
  }

  private function uidCheck($uid){
    $sqr = 'SELECT COUNT(*) FROM users WHERE uid = :uid;';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid' , $uid );
    $sth -> execute();
    return $sth -> fetchColumn();
  }

  private function pidCheck($pid){
    $sqr = 'SELECT COUNT(*) FROM post WHERE pid = :pid;';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':pid' , $pid );
    $sth -> execute();
    return $sth -> fetchColumn();
  }

  private function pidMake(){
    $try = 0;
    do {
      $try++;
      $pid = rand(PIDMIN, PIDMAX);
      $result = $this -> pidCheck($pid);
    } while( $result && $try < 9); //fetchColumnを２回以上使うなら変数に代入する必要がある。
    if($try >= 9) $pid = 0;
    return $pid;
  }

  private function uidMake(){
    $try = 0;
    do {
      $try++;
      $uid = rand(UIDMIN, UIDMAX);
      $result = $this -> uidCheck($uid);
    } while( $result && $try < 9); //fetchColumnを２回以上使うなら変数に代入する必要がある。
    if($try >= 9) $uid = 0;
    return $uid;
  }
  public function viewError(){echo "{$this ->error}({$this -> error_info})";}
  public function fetch(){return $this -> fetch_tmp;}




  public function getUserId($gid){

    $sqr = "SELECT uid FROM users WHERE gid = :gid;";
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':gid' , $gid);
    $sth -> execute();
    return $sth -> fetchAll(PDO::FETCH_ASSOC);
  }


  public function getUserProfile($uid){
    if(!$this -> uidCheck($uid)){
      return 1;
    }
    $sqr = "SELECT uid, name FROM profile WHERE uid = :uid ORDER BY update_at DESC LIMIT 1;";
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid' , $uid);
    $sth -> execute();
    $this -> fetch_tmp = $sth -> fetchAll(PDO::FETCH_ASSOC);
    return $this -> fetch_tmp;
  }


  public function updateProfile($uid, $name, $msg){
    $icon ='user.png';
    if($tmp = $this -> inputCheck($uid)){
      $this -> error = "";
      $this -> error_info = $tmp;
      return 1;
    }

    if(!($this -> uidCheck($uid))){
      $this -> error = "";
      return 1;
    }

    $sqr = 'INSERT INTO profile (uid, name, icon, msg, update_at) VALUES (:uid, :name, :icon, :msg, now());';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid' , $uid );
    $sth -> bindParam(':icon', $icon);
    $sth -> bindParam(':name', $name);
    $sth -> bindParam(':msg' , $msg );
    $sth -> execute();

    return 0;
  }
  public function getKey($uid){
    if(!($this -> uidCheck($uid))){
      $this -> error = "";
      return NULL;
    }
    $sqr = 'SELECT uid, gid FROM users WHERE uid = :uid;';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid' , $uid );
    $sth -> execute();
    $tmp = $sth -> fetchAll(PDO::FETCH_ASSOC);
    return hash('sha3-256', "{$tmp[0]['uid']}{$tmp[0]['gid']}");
  }

  public function deleteUser($uid){
    if(!($this -> uidCheck($uid))){
      $this -> error = "";
      return 1;
    }
    $sqr = 'DELETE FROM users WHERE uid = :uid;';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid' , $uid );
    $sth -> execute();
    return 0;
  }

  public function newRegist($gid, $actype, $email, $name, $msg){
    $email = "not@not";

    if($tmp = $this -> inputCheck($gid,$actype,$email,$name,$msg)){
      $this -> error = "";
      $this -> error_info = $tmp;
      return 1;
    }


    $salt = MakeSalt();
    $uid  = $this -> uidMake();
    $sqr = 'INSERT INTO users (uid, gid, AccountType, email, create_at) VALUES (:uid, :gid, :actype, :email, now());';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':uid'   , $uid     );
    $sth -> bindParam(':gid'   , $gid     );
    $sth -> bindParam(':actype', $actype  );
    $sth -> bindParam(':email' , $email   );
    $sth -> execute();
    $this -> updateProfile($uid, $name, $msg);

    return $uid;
  }

  public function newPost($uid, $title, $contents, $is_deadline, $deadline_at){
    if($tmp = $this -> inputCheck($uid, $title, $contents, $deadline_at)){
      $this -> error = "";
      $this -> error_info = $tmp;
      return 1;
    }

    if(!($this -> uidCheck($uid))){
      $this -> error = "";
      return 2;
    }

    if(!($pid = $this -> pidMake())){
      $this -> error = "";
      return 3;
    }
    $sqr = 'INSERT INTO post (pid, uid, post_title, post_contents, stat, is_deadline, deadline_at, update_at, create_at) VALUES (:pid, :uid, :title, :contents, 1, :isdl, :deadline, now(), now());';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> bindParam(':pid'     , $pid        );
    $sth -> bindParam(':uid'     , $uid        );
    $sth -> bindParam(':title'   , $title      );
    $sth -> bindParam(':contents', $contents   );
    $sth -> bindParam(':isdl'    , $is_deadline);
    $sth -> bindParam(':deadline', $deadline_at);
    $sth -> execute();
    $this -> fetch_tmp = $pid;
    return 0;

  }

  public function updatePost($pid, $deadline_at = '--NOTING--'){
    if($tmp = $this -> inputCheck($pid)){
      $this -> error = "";
      $this -> error_info = $tmp;
      return 1;
    }

    if(!($this -> pidCheck($pid))){
      $this -> error = "";
      return 1;
    }

    if($deadline_at == '--NOTING--'){
      $sqr = 'SELECT stat FROM post WHERE pid = :pid';//これ締め切り
      $sth = $this -> pdo -> prepare($sqr);
      $sth -> bindParam(':pid'  , $pid );
      $sth -> execute();
      $deadline_tmp = $sth -> fetchAll(PDO::FETCH_ASSOC);
      if($deadline_tmp[0]['stat']) $stat = 0; else $stat = 1;
      $sqr = 'UPDATE post SET stat = :stat WHERE pid = :pid';//これ締め切り
      $sth = $this -> pdo -> prepare($sqr);
      $sth -> bindParam(':pid'  , $pid );
      $sth -> bindParam(':stat'  , $stat );
      $sth -> execute();
    }else{
    }
    return 0;
}

  public function getPost($from, $num, $uid = '--NOTING--', $sort = 0){

    if(!(is_numeric($from) && is_numeric($num))){
      $this -> error = "";
      $this -> error_info = "";
      return 1;
    }
    if($uid == '--NOTING--'){
      switch($sort){
        case 4://すべて
          break;
        case 3://完了してるもの
          break;
        case 2://投稿順で完了してないもの
          break;
        case 1://遅い順かつ完了してないもの
          break;
        case 0://近い順かつ完了してないもの
        default:
        $sqr = 'SELECT * FROM post WHERE stat = 1 AND is_deadline = 1 order by deadline_at ASC LIMIT :from, :num';
          break;
      }

      $sth = $this -> pdo -> prepare($sqr);
      $sth -> bindParam(':from' , $from,  PDO::PARAM_INT );
      $sth -> bindParam(':num'  , $num ,  PDO::PARAM_INT );
    }else{
      if(!($this -> uidCheck($uid))){
        return 1;
      }

      switch($sort){
        case 4://すべて
        $sqr = 'SELECT * FROM post WHERE uid = :uid order by deadline_at ASC LIMIT :from, :num';
          break;
        case 3://完了してるもの
        $sqr = 'SELECT * FROM post WHERE uid = :uid AND stat = 0 order by oid ASC LIMIT :from, :num';
          break;
        case 2://投稿順で完了してないもの
        $sqr = 'SELECT * FROM post WHERE uid = :uid AND stat = 1  order by oid ASC LIMIT :from, :num';
          break;
        case 1://遅い順かつ完了してないもの
          $sqr = 'SELECT * FROM post WHERE uid = :uid AND stat = 1   order by deadline_at DESC LIMIT :from, :num';
          break;
        case 0://近い順かつ完了してないもの
        default:
        $sqr = 'SELECT * FROM post WHERE uid = :uid AND stat = 1  order by deadline_at ASC LIMIT :from, :num';
          break;
      }

      //$sqr = "SELECT * FROM post WHERE uid = :uid ORDER BY deadline_at ASC;"; //これ締め切り
      $sth = $this -> pdo -> prepare($sqr);
      $sth -> bindParam(':uid' , $uid);
      $sth -> bindParam(':from' , $from,  PDO::PARAM_INT );
      $sth -> bindParam(':num'  , $num ,  PDO::PARAM_INT );

    }
    $sth -> execute();
    $this -> fetch_tmp = $sth -> fetchAll(PDO::FETCH_ASSOC);

    return 0;
  }
  public function getPostNum($uid = '--NOTING--', $sort = 0){
    if($uid =='--NOTING--'){
      return $this -> post_num;
    }
    if($this -> uidCheck($uid)){
      switch($sort){
        case 4://すべて
        $sqr = 'SELECT COUNT(*) FROM post WHERE uid = :uid';
          break;
        case 3://完了してるもの
        $sqr = 'SELECT COUNT(*) FROM post WHERE uid = :uid AND stat = 0';
          break;
        case 2://投稿順で完了してないもの
        $sqr = 'SELECT COUNT(*) FROM post WHERE uid = :uid AND stat = 1 ';
          break;
        case 1://遅い順かつ完了してないもの
          $sqr = 'SELECT COUNT(*) FROM post WHERE uid = :uid AND stat = 1';
          break;
        case 0://近い順かつ完了してないもの
        default:
        $sqr = 'SELECT COUNT(*) FROM post WHERE uid = :uid AND stat = 1';
          break;
      }
      $sth = $this -> pdo -> prepare($sqr);
      $sth -> bindParam(':uid' , $uid );
      $sth -> execute();
      return $sth -> fetchColumn();
    }else{
      return 0;
    }
  }
  public function getName(){
    $sqr = 'SELECT uid, name FROM profile';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> execute();
    return $sth -> fetchAll(PDO::FETCH_KEY_PAIR);

  }

  public function getIcon(){

    $sqr = 'SELECT uid, icon FROM profile';
    $sth = $this -> pdo -> prepare($sqr);
    $sth -> execute();
    return $sth -> fetchAll(PDO::FETCH_KEY_PAIR);

  }

}
