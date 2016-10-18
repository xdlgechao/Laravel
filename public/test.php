<?php 

	// $arr = [
	// 	1,2,3,4,5,6
	// ];

	// foreach ($arr as $key => &$value) {
	// 	$value = 10;
	// 	// $arr[$key] = 10;
	// }
	// // var_dump($key);
	// // var_dump($value);
	// var_dump($arr);
	
	// $str = "我爱你亲爱的姑娘";

	// var_dump(mb_strlen($str));

	class A
	{
		public function funcA()
		{
			echo 'AAAAA';
		}
	}

	class B
	{
		public $a = null;
		public function __construct(A $a)
		{
			$this->a = $a;
		}
		public function funcB()
		{
			$this->a->funcA();

			echo 'BBBB';
		}
	}

	class C
	{
		public $b = null;
		public function __construct(B $b)
		{
			$this->b = $b;
		}

		public function funcC()
		{
			$this->b->funcB();
			echo 'CCCCC';
		}
	}

	class Container
	{
		private $data = [];
		public function bind($name, $value)
		{	
			$this->data[$name] = $value;
		}

		public function make($name)
		{
			return $this->data[$name]($this);
		}

	}

	$container = new Container;

	$container -> bind('A', function($container){
		return new A;
	});

	$container -> bind('B', function($container){
		return new B($container->make('A'));
	});

	$container -> bind('C', function($container){
		return new C($container->make('B'));
	});

	$a = $container->make('A');
	// var_dump($a);
	$b = $container->make('B');
	// var_dump($b);
	$c = $container->make('C');
	var_dump($c);


 ?>