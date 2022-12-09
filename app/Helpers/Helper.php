<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function getFullName($user)
{
    return ucwords($user->first_name . ' ' . $user->last_name);
}

function GetUserRole($user)
{
    $userRole = $user->roles;
    return count($userRole) > 0 ? $userRole[0]->name : '';
}

function convertDateTime($timestamp, $only_date = false)
{
    if ($timestamp !== null) {
        return $only_date ? Carbon::parse($timestamp)->format('d M, Y') : Carbon::parse($timestamp)->format('d M, Y g:i A');
    }
}

function getImage($image, $isAvatar = false, $withBaseurl = false)
{
    $errorImage = $isAvatar ? url('/images/no_avatar.png') : url('/images/no_image.png');
    return !empty($image)  ? ($withBaseurl ?  url('/storage/' .$image) : Storage::url($image)) : $errorImage;
}

function saveResizeImage($file, $directory, $width, $type = 'jpg')
{
    if (!Storage::exists($directory)) {
        Storage::makeDirectory("$directory");
    }
    $is_preview = strpos($directory, 'previews') !== false;
    $filename = Str::random() . time() . '.' . $type;
    $path = "$directory/$filename";
    $img = \Image::make($file)->orientate()->encode($type, $is_preview ? 40 : 85)->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    if ($width == $is_preview) {
        $img = $img->blur(60);
    }
    $resource = $img->stream()->detach();
    //add public
    Storage::disk('public')->put($path, $resource, 'public');
    return $path;
}

function formatString($key, $reverse = false) {
    if ($reverse) {
        return str_replace([' ', "'"],'_', strtolower($key));
    } else {
        return str_replace(['_','-'],' ', strtolower($key));
    }
}

function isValue($value) {
    if ($value !== 'undefined' && $value !== null && !empty($value)) {
        return $value;
    } else {
        return 'N/A';
    }
}

function statusClasses($status)
{
    $class = '';
    switch ($status) {
        case 'active':
        case 'approved':
        case 'accepted':
        case 'delivered':
        case 'completed':
        case 'invoiced':
            $class = 'success';
            break;
        case 'rejected':
        case 'inactive':
        case 'cancelled':
        case 'submitted':
        case 'cancelled':
            $class = 'danger';
            break;
        case 'in_review':
        case 'pending':
        case 'in progress':
        case 'incomplete':
            $class = 'warning';
            break;
        
    }
    return $class;
}

function addEllipsis($text, $max = 30)
{
    return strlen($text) > 30 ? mb_substr($text, 0, $max, "UTF-8") . "..." : $text;
}