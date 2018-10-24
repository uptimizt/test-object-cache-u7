<?php
/*
* Plugin Name: U7 Test Object Cache
* Description: Тестируем объектный кеш в WordPress через шорткод и засыпание
* Author: uptimizt
* Author URI: https://github.com/uptimizt
* Version: 0.1
*/

add_shortcode('test', function(){
  ob_start();


  $time_start = microtime(TRUE);

  if( ! $data = wp_cache_get('test_key', $group = 'test_group')){
    echo 123;
    $data = slow_fn();
    wp_cache_set( $key = 'test_key', 222, $group = 'test_group', $expire = 999999999 );
  }

  $time_end = microtime(TRUE) - $time_start;

  printf('<h1>time end</h1><p>%s</p>', $time_end);

  echo '<h1>var_dump</h1>';

  var_dump($data);

  if( isset($_GET['r']) ){
    wp_cache_delete('test_key', $group = 'test_group');
  }

  return ob_get_clean();
});


function slow_fn(){
  sleep(10);
  return 111;
}
