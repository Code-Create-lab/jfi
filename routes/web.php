<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/booking', 'pages.booking')->name('booking');
Route::view('/event', 'pages.event')->name('event');
Route::view('/membership', 'pages.membership')->name('membership');
Route::view('/service', 'pages.service')->name('service');
Route::view('/coaching', 'pages.coaching')->name('coaching');
Route::view('/community', 'pages.community')->name('community');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/blog/single-post', 'pages.single-post')->name('single-post');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/404', 'errors.404')->name('not-found');
