<?php
/**
 * Created by PhpStorm.
 * User: ydz
 * Date: 17/3/9
 * Time: 下午5:13
 */

namespace Home\Controller;


use Think\Controller;

class loginController extends Controller{


//    private $userId;
//    调用视图模版
    public function loadView(){

//        path:home/view/Login/loadView.html
        $this->display();
    }



//    用户注册
    public function regist(){
//        global $userId;
//        $this->userId = '3';
        $userName = I('post.username','','trim');
        $passward = I('post.pwd','','trim');
        $registTime = I('post.registTme','','trim');

        if(!empty($userName)&&!empty($passward)&&!empty($registTime)){

            $loginModel = M('user_info');
            $nameList=$loginModel->field('userName')->select();
            $contentNameArr = array();
            foreach($nameList as $value){
                foreach($value as $name){
                    $contentNameArr[]=$name;
                }
            }
            $isin = in_array($userName,$contentNameArr);
            if($isin){
                echo json_encode(['msg'=>'该用户已被注册']);
            }else{
                $data['userName']=$userName;
                $data['passward']=$passward;
                $data['registTime'] = $registTime;
                $loginModel->add($data);
                $source=$loginModel->select();
                $checkName['userName'] = $userName;
                $userInfo = $loginModel->where($checkName)->find();
                echo json_encode(['msg'=>'注册成功','code'=>'200','userId'=>$userInfo['id']]);
            }
        }else if(empty($userName)){
            echo json_encode(['msg'=>'请输入正确的用户名']);
        }elseif(empty($passward)){
            echo json_encode(['msg'=>'请输入正确的密码']);
        }else{
            echo json_encode(['msg'=>'请输入正确用户名以及密码']);
        }
    }
//      后台用户登录
    public function loginBase(){
        $this->display();
    }

//    API 用户登录
    public function login(){
//        var_dump($this->userId);
//        die();
        $name = I('post.username','','trim');
        $pwd = I('post.pwd','','trim');
        if(empty($name)){
            echo json_encode(['msg'=>'请输入用户名']);
        }elseif(empty($pwd)){
            echo json_encode(['msg'=>'请输入密码']);
        }elseif(empty($name)&&empty($pwd)){
            echo json_encode(['msg'=>'你还登录个毛线啊']);
        }else{

            $userinfo = M('user_info');
            $search['userName'] = $name;
            $user = $userinfo->where($search)-> find();

            echo json_encode($user);
            exit();
            /*
            if(!empty($user['userName'])){

                if($user['passward']==$pwd){
                    echo json_encode(['msg'=>'登录成功','code'=>'200','id'=>$user['id']]);

                }else{
                    echo json_erncode(['msg'=>'密码不正确']);

                }
            }else{
                echo json_encode(['msg'=>'该用户未注册']);

            }
            */
        }
    }
//    动态数据
    public function comments(){
        $limitId = I('post.id','','trim');
        if(!empty($limitId)){
            $comments = M('user_comment');
            $search['id']=array('egt',$limitId);
            //查询大于等于该id后10条数据
            $commentList = $comments->where($search)->limit(20)->select();
            echo json_encode($commentList);
        }


    }
//    更新个人资料
    public function updateInfo(){
        $nickname = I('post.nickname','','trim');
        $gender = I('post.gender','','trim');
        $isVip = I('post.vip','','trim');
        $id = I('post.id','','trim');
        $user = M('user_info');
        if(empty($id)){
            echo json_encode(['msg'=>'未找到用户']);
            return;
        }
        $data = array();
        if(!empty($nickname)){
            $data['nick'] = $nickname;
         }
        if(!empty($gender)){
            $data['gender'] = $gender;
        }
        if(!empty($isVip)){
            $data['type'] = $isVip;
        }
        $user->where($id)->save($data);
        echo json_encode(['msg'=>'保存成功']);
    }
//    上传头像
    public function updateAvatar(){

    }
//      签到
    public function userSign(){
        $id = I('post.id','','trim');
        $time = I('post.signTime','','trim');
        if(empty($id)){
            echo json_encode(['msg'=>'未找到用户']);
            return;
        }
        $user = M('user_info');
        $data['signTime'] = $time;
        $search['id'] = $id;
        $forwardTime = $user->where($search)->field('signTime')->find();
        if($forwardTime['signTime']===$time){
            echo json_encode(['msg'=>'今天已经签到']);
            return;
        }
        $count = $user->where($search)->field('count')->find();
        $num = $count['count'].'4';
        $data['count'] = $num;
        $user->where($id)->save($data);
        echo json_encode(['msg'=>'签到成功']);

    }
}