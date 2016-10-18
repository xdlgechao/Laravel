1.构建网站的步骤
	a) 安装laravel
	b) 配置虚拟主机
	c) 创建路由规则 (显示页面)
	d) 将静态模板的html代码 复制到模板页面中
	e) 调整路径

2.api手册地址
	http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/File/UploadedFile.html#method_getClientOriginalExtension
	https://cs.phphub.org/

3.关于网站应用中的路径
	页面路径 html页面中的路径
		相对路径
			页面中所有的相对路径, a href , form action, img src, link href, script src,ajax url ,iframes src
			都是参数当前页面中最后一个/的那个元素
		绝对路径
			所有的页面的绝对路径 都是参数域名所对应的根目录

	脚本路径: php代码中的路径
		相对路径:
			所有的脚本中的相对路径都是参数入口文件.
		绝对路径:
			绝对路径是当前系统的根目录(如果是linux就是/,如果是windows是当前代码所在的盘符)

4.数据的填充  (文件夹位置 database/seeds)
	1.创建类文件     php artisan make:seeder UsersSeeder
	2.填写注入代码   在创建的文件中进行数据填充 ->  在DatabaseSeeder文件中进行调用
	3.执行           php artisan db:seed

5.代码格式化 (百度搜索格式化html)


6.自动验证:  将验证的动作交给另一个类来完成.
	1.创建请求的类文件
		php artisan  make:request  InsertCateRequest
	2.将该文件的authorize方法改成return true
	3.在rules方法中填写 验证规则
	4.在messages(默认没有这个方法需要手动添加) 方法中添加信息提示.
	5.在控制器方法中使用该类型约束来限定的请求的参数. (别忘了导入类)
		public function postInsert(StoreCateRequest $request)
    	{

    	}

7. 可以将数据库的查询结果转变成数组形式  $res->toArray();

8.关于自动引入自定义的函数文件和类文件

9.使用laravel中的migrate来设计表
	a) 创建迁移文件  php artisan make:migration create_table_users
	b) 创建表结构
		public function up()
	    {
	        //
	        Schema::create('articles', function (Blueprint $table) {
	            $table->increments('id')->comment('主键自增id');
	            $table->string('title')->comment('文章的标题');
	            $table->text('intro')->comment('文章的摘要');
	            $table->text('content')->comment('文章的内容');
	            $table->integer('cate_id')->comment('文章的分类id');
	            $table->string('img')->comment('文章的主图');
	            $table->string('thumb')->comment('文章的缩略图');
	            $table->timestamps();
	        });
	    }

	    /**
	     * Reverse the migrations.
	     *
	     * @return void
	     */
	    public function down()
	    {
	        //
	        Schema::drop('articles');
	    }
	c) 创建表结构  php artisan migrate 
	d) 修改表结构 
	e) 刷新表结构  php artisan migrate:refresh

10.关于foreach遍历
	$arr = [
		1,2,3,4,5,6
	];

	foreach ($arr as $key => &$value) {
		$value = 10;
		// $arr[$key] = 10;
	}
	// var_dump($key);
	// var_dump($value);
	var_dump($arr);

11.关于第三方插件的使用
	a) 看文档.
	b) 比猫画虎

12.编辑器插件的快速使用
	配置步骤
	a) 复制文教到public目录下
	b) 将js文件导入代码放置到模板文件中  并调整文件路径
	c) 创建容器, 将script标签容器放置到需要显示的位置
	d) 实例化
       	var ue = UE.getEditor('editor');

	使用注意点:
		1.修改编辑器的name属性 来调整参数的名称.
		2.调整编辑器文章上传的默认路径  ueditor/php/config.js   
			修改属性 imagePathFormat属性
		3.功能菜单的自定义
			var ue = UE.getEditor('editor', {toolbars: [
                ['fullscreen', 'source', 'undo', 'redo', 'bold','simpleupload']
            ]});

13 要求使用限制一个字符串个数大于某个值?

14. 如果需要修改默认创建的控制器文件的注释可以修改该文件
	project\vendor\laravel\framework\src\Illuminate\Routing\Console\stubs\DummyClass

15. 当修改表机构的时候 可以使用该命令快速完成调整
	php artisan migrate:refresh --seed


16.表设计的原则
		1.字段的内容不能再分
		2.字段的值不允许重复(但是键除外)


17.  创建url的函数
	url()
	asset()
