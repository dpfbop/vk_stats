<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('{public_name}', function($public_name)
{
	$id = preg_replace('/[a-z]/', '', $public_name);
	$id = (int)$id;
	$dots = Dot::where('public_id', $id)->orderBy('time_diff', 'asc')->get();
	if (count($dots) == 0) {
		return View::make('index');
	}
	$data = array();
	foreach ($dots as $dot) {
		array_push($data, $dot);
	}
	$i = 0;
	$avg = array();
	$step = 60 * 10;
	for ($cur = 0; $cur < 24 * 60 * 60; $cur += $step) {
		$tmp = array();
		while ($i < count($data) && $data[$i]['time_diff'] >= $cur && $data[$i]['time_diff'] < $cur + $step) {
			array_push($tmp, $data[$i]);
			$i += 1;
		}
		$likes = 0;
		$time = 0;
		if (count($tmp) == 0)
			continue;
		foreach ($tmp as $dot) {
			$likes += $dot['likes_count'];
			$time += $dot['time_diff'];
		}
		$likes = (double)$likes / count($tmp);
		$time = (double)$time / count($tmp);
		array_push($avg, array('time_diff' => $time, 'likes_count' => $likes));
	}
	$dots = $avg;

    return View::make('public')->with(compact('dots'))->with('caption', (string)$id);
})
->where('public_name', '[a-z0-9A-Z]+');