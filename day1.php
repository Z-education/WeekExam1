<?php

function sum1($n) {
    //执行1次
    $sum = 0; //用于计算和存储结果
    for ($i = 1; $i <= $n; $i++) {
        $sum += $i; //执行n次
    }
    return $sum; //执行1次
}

//echo sum1(100);
//时间复杂度：1 + n + 1 = 2 + n = n (复杂度当中常数可以忽略) = O(n);
//空间复杂度：（$n,$i,$sum） = 1+1+1 = 3 = 1 (复杂度中，如果只有常数，可作为1) = O(1);
//函数内部调用函数本身，就是递归
function sum2($n, $i = 1, $sum = 0) {
    if ($i <= $n) { // n
        $sum += $i; // n
        $i++;   // n
        return sum2($n, $i, $sum); // n
    } else {
        return $sum; // 1
    }
}

//echo sum2(100);
//时间复杂度：n+n+n+n+1 = 1 + 4n = n = O(n)
//空间复杂度：（$n, $i, $sum） * (n + 1) = 3 * (n + 1) = n = O(n);

function jiecheng($n) {
    $sum = $n; // 1
    for ($i = 1; $i < $n; $i++) {
        $sum *= $n - $i; //n-1
    }
    return $sum; // 1
}

//时间复杂度： 1 + n - 1 + 1 = 1 + n = n = O(n);
//123321   12321    123123321
function huiwen($str) {
    $rev = '';
    $revarr = [];
    for ($i = 0; $i < strlen($str); $i++) {
        array_unshift($revarr, $str[$i]); //在数组的开头插入元素
    }
    for ($i = 0; $i < count($revarr); $i++) {
        $rev .= $revarr[$i];
    }
    return $str == $rev;
}

// 1 + 1 + n + n + 1 = 3 + 2n = n = O(n);

function huiwen2($str) {
    $rev = '';
    $len = strlen($str);
    for ($i = $len - 1; $i >= 0; $i--) {
        $rev .= $str[$i];
    }
    return $str == $rev;
}

// 1 + 1 + n + 1 = 3 + n = n = O(n); 

function huiwen3($str) {
    $len = strlen($str);
    $start = 0;
    $end = $len - 1;
    $count = floor($len / 2);
    for ($i = 0; $i < $count; $i++) {
        if ($str[$start] == $str[$end]) {
            $start++;
            $end--;
        } else {
            return false;
        }
    }
    return true;
}

function day1($str) {
    $str = str_replace(' ', '', $str);
    $len = strlen($str);
    $arr = [];
    for ($i = 0; $i < $len; $i++) {
        if (isset($arr[$str[$i]])) {
            $arr[$str[$i]] ++;
            if ($arr[$str[$i]] == 3) {
                return $str[$i];
            }
        } else {
            $arr[$str[$i]] = 1;
        }
    }
    return false;
}

$_GET['n'] = 0;

function sort1($arr) {
    $len = count($arr); // 1
    for ($i = 1; $i <= $len; $i++) {
        //n
        for ($k = 0; $k < $len - $i; $k++) {
            //n
            if ($arr[$k] > $arr[$k + 1]) {
                $arr[$k] = $arr[$k] ^ $arr[$k + 1];
                $arr[$k + 1] = $arr[$k] ^ $arr[$k + 1];
                $arr[$k] = $arr[$k] ^ $arr[$k + 1];
            }
            $_GET['n'] ++;
        }
    }
    return $arr;
}

//时间复杂度：1 + (n * n) = 1 + n^2 = n^2 = O(n^2)

function sort2($arr) {
    //获取当前数组的长度
    $len = count($arr);
    if ($len < 2) {
        //如果长度小于2，那么不需要处理直接返回
        return $arr;
    }
    $middle = $arr[0];  //获取一个中间点
    $left = []; //比中间点小的值存放的数组
    $right = []; //比中间但大的值存放的数组
    for ($i = 1; $i < $len; $i++) {
        if ($arr[$i] > $middle) {
            //如果当前元素 大于 中间点的值，放入 right
            $right[] = $arr[$i];
        } else {
            //小于 中间点 放入 left
            $left[] = $arr[$i];
        }
        $_GET['n'] ++;
    }
    $left = sort2($left);   //递归调用，再次处理leftright数组，直至数组元素个数小于2
    $right = sort2($right); //递归调用，再次处理leftright数组，直至数组元素个数小于2
    //合并所有值
    return array_merge($left, [$middle], $right);
}

//基数排序（桶排序）
function sort3($arr) {
    $len = count($arr);
    if ($len < 2) {
        return $arr;
    }
    //创建一个桶
    $tong = [];
    for ($i = 0; $i < 10; $i++) {
        $tong[$i] = [];
    }
    //使用max函数获取数组中的最大值，并且获取最大值的长度
    $max_length = strlen(max($arr));
    for ($i = 0; $i < $max_length; $i++) {
        //pow用于指数计算，pow($a, $b); 计算 $a 的 $b 次方
        //计算取模的指数：个位=10 十位=100 百位=1000
        $mo = pow(10, $i + 1);
        //计算除数的指数：个位=1 十位=10 百位=100
        $chu = pow(10, $i);
        // 取出 123的个位数  123 % 10 / 1 = 3
        //          十位数  123 % 100 / 10 = 2
        //循环遍历数组中的所有数据
        for ($k = 0; $k < $len; $k++) {
            //获取每一个位数的值 个位 十位 百位 千位
            //第一次 1 7 6 0 5 ：获取到这个数字之后，
            //将每一个数字对应的值，放入到对应编号的桶中
            $exp = floor($arr[$k] % $mo / $chu);
            //第一次的结果
            /*
             * [
             *  0 => [190],
             *  1 => [521],
             *  2 => [],
             *  3 => [],
             *  4 => [],
             *  5 => [325],
             *  6 => [286],
             *  7 => [647],
             *  8 => [],
             *  9 => [],
             * ]
             */
            /*
             * 第二次结果
             * $tong = [
             *  0 => [],
             *  1 => [],
             *  2 => [521,325],
             *  3 => [],
             *  4 => [647],
             *  5 => [],
             *  6 => [],
             *  7 => [],
             *  8 => [286],
             *  9 => [190],
             * ]
             */
            /*
             * 第三次结果
             * $tong = [
             *  0 => [],
             *  1 => [190],
             *  2 => [286],
             *  3 => [325],
             *  4 => [],
             *  5 => [521],
             *  6 => [647],
             *  7 => [],
             *  8 => [],
             *  9 => [],
             * ]
             */
            $tong[$exp][] = $arr[$k];
            $_GET['n'] ++;
        }
        //将数组清空
        $arr = [];
        //遍历桶里的数据
        for ($t = 0; $t < 10; $t++) {
            if (!empty($tong[$t])) {
                for ($l = 0; $l < count($tong[$t]); $l++) {
                    //将桶内的数据转存到$arr中
                    $arr[] = $tong[$t][$l];
                }
                $_GET['n'] ++;
                //当前这个桶的数据已经转存到$arr，清空桶内的数据
                $tong[$t] = [];
            }
        }
        /* 第一次
         * $arr = [
         *  190,521,325,286,647
         * ]
         * 第二次
         * $arr = [
         *  521,325,647,286,190
         * ];
         * 第三次
         * $arr = [
         *  190,286,325,521,647
         * ];
         */
    }
    return $arr;
}

//sort3([521,647,212,190,325]);
//echo $_GET['n'];


function nb($arr) {
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $q = '';
        for ($qi = 0; $qi < $i; $qi++) {
            $q = $q + $arr[$qi];
        }
        $h = '';
        for ($hou = $i + 1; $hou < $len; $hou++) {
            $h = $h + $arr[$hou];
        }
        if ($q == $h) {
            return $i;
        }
    }
    return false;
}
$arr =  [20, 30, 50,  40,  10,  30,  10,  50];

$arr__ =[240,220,190, 140, 100, 90,  60 , 50];
$arr_ = [20, 50, 100, 140, 150, 180, 190, 240];
//var_dump(nb2($arr));
function nb2($arr){
    $len = count($arr);
    $arr_ = [];//用于存储每一个位置的和
    for($i = 0; $i < $len; $i++){
        if(isset($arr_[$i-1])){
            $arr_[] = $arr[$i] + $arr_[$i-1];
        }else{
            $arr_[] = $arr[$i];
        }
    }
    $tmp = 0;
    for($k = $len - 1; $k > 1; $k--){
        $tmp += $arr[$k];
        if($arr_[$k - 2] == $tmp){
            return $k - 1;
        }
    }
    return false;
}

function shui($n, $m){
    $arr = [];
    for($i = $n; $i <= $m; $i++){
        if(strlen($i) != 3){
            continue;
        }
        $b = floor($i / 100);
        $s = floor(($i % 100) / 10);
        $g = $i % 10;
        $sum = pow($b, 3) + pow($s, 3) + pow($g, 3);
        if($sum == $i){
            $arr[] = $i;
        }
    }
    return $arr;
}

function func($num){
    $list = range('a', 'z');
    $count = count($list);
    $arr = [];
    while($num){
        $tmp = floor($num / $count);//商
        $rem = $num % $count;//余
        if($rem == 0){
            $tmp--;
            array_unshift($arr, $list[$count - 1]);
        }else{
            array_unshift($arr, $list[$rem - 1]);
        }
        $num = $tmp;
    }
    return implode('', $arr);
}

function fbnq($n){
    $arr = [];
    for($i = 0; $i < $n; $i++){
        if($i < 2){
            $arr[] = 1;
        }else{
            $arr[] = $arr[$i - 1] + $arr[$i - 2];
        }
    }
    print_r($arr);
}

/*
 * 银行四个窗口，求平均等待时间
 * @param array $active_time 用户到达银行的时间
 * @param array $process_time 用户办理业务需要的时间
 */
function bank($active_time, $process_time){
    $windows = [];//窗口
    $wait_time = 0;//总等待时间
    $number = count($active_time);//总人数
    for($i = 0; $i < $number; $i++){
        if(count($windows) < 4){
            //如果当前窗口未满，直接将当前用户放入窗口，并计算其离开时间
            $windows[] = $active_time[$i] + $process_time[$i];
            continue;
        }
        //将数组排序，把最早离开的用户，放在最前面
        sort($windows);
        //取出最早离开的用户的时间
        $min = array_shift($windows);
        if($min > $active_time[$i]){
            //如果最早离开的时间 大于 下一位用户的到达时间，那么计算下位用户的等待时间
            //并计算到总等待时间种
            $wait_time += $min - $active_time[$i];
            //将用户开始办理业务的时间 + 所需要的时间
            $now_windows_time = $min + $process_time[$i];
        }else{
            //当前窗口有空闲，计算当前用户的离开时间
            $now_windows_time = $active_time[$i] + $process_time[$i];
        }
        //将新用户放入窗口
        $windows[] = $now_windows_time;
    }
    //返回平均等待时间
    return $wait_time / $number;
}
bank([
    9.00, 9.05, 9.10, 9.20, 9.21, 9.25, 9.28, 9.30
],[
    0.30, 0.31, 0.35, 0.40, 0.38, 0.50, 0.55, 0.33
]);