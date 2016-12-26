<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

    /**
     * 控制器控制页面输出
     * 获取session内容，将用户名传入页面
     * 设置页面的编号index和标题title，传入页面，控制页面输出
     * 1.display公共页面header，bottom
     * 2.display用户相关的页面
     * 0.代码重用
     **/
    public function userCenter(){
        $user_name = session('user_name');
        $this->assign('user_name',$user_name);
        $index=6;
        $this->assign('index',$index);
        $this->display('Common:header');
    	$this->display();
    	$this->display('Common:bottom');
    }
    function myDesign(){
        $user_name = session('user_name');
        $this->assign('user_name',$user_name);
        $index = 6;
        $title = '我的作品';
        $secondfloor = array(
            'fisrt'     =>  array('name' => 'one'),
            'second'    =>  array('name' => 'two'),
            'third'     =>  array('name' => 'three'),
            'forth'     =>  array('name' => 'one'),
            );
        $this->assign('secondfloor',$secondfloor);
        $this->assign('index',$index);
        $this->assign('title',$title);
        $this->display('Common:header');
    	$this->display();
    	$this->display('Common:bottom');
    }
    function updateUserinfo(){
        $this->display('Common:header');
    	$this->display();
    	$this->display('Common:bottom');
    }
    function accountCenter(){
        $user_name = session('user_name');
        $this->assign('user_name',$user_name);
        $index=6;
        $this->assign('index',$index);
        $this->display('Common:header');
    	$this->display();
    	$this->display('Common:bottom');
    }
    function myCircle(){
        $user_name = session('user_name');
        $this->assign('user_name',$user_name);
        $index=6;
        $this->assign('index',$index);
        $this->display('Common:header');
        $this->display();
        $this->display('Common:bottom');
    }
    function uploadDesign(){
        $user_name = session('user_name');
        $this->assign('user_name',$user_name);
        $index=6;
        $this->assign('index',$index);
        $this->display('Common:header');
        $this->display();
        $this->display('Common:bottom');  
             
    }
    /**
     * 上传文件功能
     * 1.继承核心方法upload
     * 2.配置上传参数
     * 3.将上传的参数传入上传的页面
     * 4.调用回调函数，打印上传的成功或失败的信息
     * @return [type] [description]
     */
    function upload()
    {
        $upload = new \Think\Upload(); 
        $upload->maxSize = 3145728 ;    
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath = './Public/Uploads/';  
        $info = $upload->upload();    
        if(!$info) {        
            $this->error($upload->getError());    
        }else{      
            $this->success('上传成功！','User/');    
        } 
    }

    /**
     * 登录验证功能
     * 1.判断验证码的正确错误
     * 2.在数据库中检查用户名和密码是否都存在
     * 3.将匹配成功的用户名和密码存入session，重定向到此页面
     * 0.使用tp框架集成的方法
     **/
    public function login(){
        if(!empty($_POST))
        {
            $verify=new \Think\Verify();
            if(!$verify->check($_POST['captcha'])){
                echo "验证码错误";
            }
            else{
                $user = new \Home\Model\UserModel(); 
                $res=$user->checkNamePwd($_POST['user_name'],$_POST['password']);
                if($res==false){
                    echo "用户名或密码错误";            
                }else{
                    session('user_name',$res['user_name']);
                    session('id',$res['id']);
                    echo session('user_name');
                    $this->redirect('Index/index');   
                }   
            }
        }
    }

    /**
     * 注册功能
     * 1.判断验证码是否正确
     * 2.判断用户名符合规范
     * 3.判断密码是否符合规范
     * 4.调用函数，将用户名密码插入到user数据库表中
     * 5.注册成功，存入session并登录
     */
    public function register(){

    }

    /**
     * 自动生成验证码
     * 1.配置验证码参数
     * 2.构造验证码对象
     * 3.验证码传递到页面
     * 0.tp框架集成的方法
     **/               
    public function verify(){
        ob_clean();
        $config=array(
        'imageH'    =>  30,               
        'fontSize'  =>  12, 
        'fontttf'   =>  '4.ttf',
        'useCurve'  =>  false, 
        'length'    =>  4,  
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
        
    }
    
     /**
     * 登出
     * 1.将session清空
     * 2.重定向到此页，未登录状态
     * 0.
     **/   
    public function logout(){
        session(null);
        $this->redirect('Index/index');
        
    }
   
}