<?php

/**
 * php实现排序算法
 * Class algorithm
 */
class algorithm {

    /**
     * 冒泡算法
     * 思路：对当前还未排好的数组，从前往后对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒
     * @param $params
     * @return mixed
     */
    function bubble($data) {
        $len = count($data);

        if ($len<=1) {
            return $data;
        }

        for($i=1; $i<$len; $i++) {
            for($k=0; $k<$len-$i; $k++) {
                if ($data[$k] < $data[$k+1]) {
                    $tmp = $data[$k];
                    $data[$k] = $data[$k+1];
                    $data[$k+1] = $tmp;
                }
            }
        }

        return $data;
    }

    /**
     * 快速排序
     * 思路：选择一个基准元素，通常选择第一个元素或者最后一个元素。
     *      通过一趟扫描，将待排序列分成两部分，一部分比基准元素小，一部分大于等于基准元素。
     *      此时基准元素在其排好序后的正确位置，然后再用同样的方法递归地排序划分的两部分
     * @param $params
     * @return mixed
     */
    function quick($data) {
        $len = count($data);

        if ($len<=1) {
            return $data;
        }

        $base = $data['3'];
        $left_data = array();
        $right_data = array();

        for($i=1; $i<$len; $i++) {
            if ($data[$i] < $base) {
                $left_data[] = $data[$i];
            } else {
                $right_data[] = $data[$i];
            }
        }

        $left_data = $this->quick($left_data);
        $right_data = $this->quick($right_data);

        return array_merge($left_data, array($base), $right_data);
    }


    /**
     * 插入排序
     * 思路：在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序
     * @param $data
     * @return mixed
     */
    function insert($data) {
        $len = count($data);

        if ($len<=1) {
            return $data;
        }

        for($i=0; $i<$len; $i++) {
            $tmp = $data[$i];
            for($j=$i-1; $j>=0; $j--) {
                if ($tmp < $data[$j]) {
                    $data[$j+1] = $data[$j];
                    $data[$j] = $tmp;
                } else {
                    break;
                }
            }
        }

        return $data;
    }

    /**
     * 选择排序
     * 思路：在要排序的一组数中，选出最小的一个数与第一个位置的数交换。
     * 然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止
     * @param $data
     * @return mixed
     */
    function select($data) {
        $len = count($data);

        if ($len<=1) {
            return $data;
        }

        for($i=0; $i<$len; $i++) {
            //默认设置$i为最小的元素
            $p = $i;
            for($j=$i+1; $j<$len; $j++) {
                if ($data[$p] > $data[$j]) {
                    $p = $j;
                }
            }

            //$p就是最小的元素，把$i对应的值设置为$p对应的值
            $tmp = $data[$p];
            $data[$p] = $data[$i];
            $data[$i] = $tmp;
        }

        return $data;
    }


    /**
     * 二分查找
     * 思路：先取数组中间的值floor((low+top)/2), 然后通过与所需查找的数字进行比较，
     *      若比中间值大，则将首值替换为中间位置下一个位置，继续第一步的操作；
     *      若比中间值小，则将尾值替换为中间位置上一个位置，继续第一步操作 ，重复第二步操作直至找出目标数字
     * @param $data
     * @return mixed
     */
    function binary($data, $target) {
        $len = count($data);

        if ($len < 1) {
            return false;
        }

        $left = 0;
        $right = $len - 1;

        while ($left < $right) {
            $mid = floor(($right - $left) / 2);

            if ($data[$mid] == $target) {
                return $target;
            } else if ($data[$mid] < $target) {
                $left = $mid+1;
            } else {
                $right = $mid-1;
            }
        }

        return false;
    }

    /**
     * 二分查找（递归法）
     * @param $data
     * @param $target
     * @param $left
     * @param $right
     * @return bool
     */
    function binary2($data, $target, $left, $right) {
        $len = count($data);

        if ($len < 1) {
            return false;
        }

        $mid = floor(($right - $left) / 2);

        if ($data[$mid] == $target) {
            return $target;
        } else if ($data[$mid] < $target) {
            $this->binary2($data, $target, $mid+1, $right);
        } else {
            $this->binary2($data, $target, $left, $mid-1);
        }

        return false;
    }

    /**
     * 顺序查找
     * 思路：从数组的第一个元素开始一个一个向下查找，如果有和目标一致的元素，查找成功；
     *      如果到最后一个元素仍没有目标元素，则查找失败
     * @param $data
     * @return mixed
     */
    function search($data, $target) {
        $len = count($data);

        if ($len < 1) {
            return false;
        }

        for($i=0; $i<$len; $i++) {
            if ($data[$i] == $target) {
                return $data[$i];
            }
        }

        return false;
    }
    
    /**
     * 归并排序
     *1）“分解”——将序列每次折半划分。
     *2）“合并”——将划分后的序列段两两合并后排序。
     */
    // 递归
    function mergeSort(&$arr, $left, $right) {
        if ($left < $right) {
            // 找出中间索引
            $mid = floor(($left + $right) / 2);
            // 对左边数组进行递归
            mergeSort($arr, $left, $mid);
            // 对右边数组进行递归
            mergeSort($arr, $mid + 1, $right);
            // 合并
            merge($arr, $left, $mid, $right);
        }
    }

    // 将两个有序数组合并成一个有序数组
    function merge(&$arr, $left, $mid, $right) {
        $i = $left;     // 左数组的下标
        $j = $mid + 1;  // 右数组的下标
        $temp = array();// 临时合并数组
        // 扫描第一段和第二段序列，直到有一个扫描结束
        while ($i <= $mid && $j <= $right) {
            // 判断第一段和第二段取出的数哪个更小，将其存入合并序列，并继续向下扫描
            if ($arr[$i] < $arr[$j]) {
                $temp[] = $arr[$i];
                $i++;
            } else {
                $temp[] = $arr[$j];
                $j++;
            }
        }
        // 比完之后，假如左数组仍有剩余，则直接全部复制到 temp 数组
        while ($i <= $mid) {
            $temp[] = $arr[$i];
            $i++;
        }
        // 比完之后，假如右数组仍有剩余，则直接全部复制到 temp 数组
        while ($j <= $right) {
            $temp[] = $arr[$j];
            $j++;
        }
        // 将合并序列复制到原始序列中
        for($k = 0; $k < count($temp); $k++) {
            $arr[$left + $k] = $temp[$k];
        }
    }

    // 测试
    $arr = [85, 24, 63, 45, 17, 31, 96];
    mergeSort($arr, 0, count($arr) - 1);
    print_r($arr);
    
    // 归并排序主程序
    function mergeSort($arr) {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        } // 递归结束条件, 到达这步的时候, 数组就只剩下一个元素了, 也就是分离了数组

        $mid = intval($len / 2); // 取数组中间
        $left = array_slice($arr, 0, $mid); // 拆分数组0-mid这部分给左边left
        $right = array_slice($arr, $mid); // 拆分数组mid-末尾这部分给右边right
        $left = mergeSort($left); // 左边拆分完后开始递归合并往上走
        $right = mergeSort($right); // 右边拆分完毕开始递归往上走
        $arr = merge($left, $right); // 合并两个数组,继续递归

        return $arr;
    }

    // merge函数将指定的两个有序数组(arrA, arr)合并并且排序
    function merge($arrA, $arrB) {
        $arrC = array();
        while (count($arrA) && count($arrB)) {
            // 这里不断的判断哪个值小, 就将小的值给到arrC, 但是到最后肯定要剩下几个值,
            // 不是剩下arrA里面的就是剩下arrB里面的而且这几个有序的值, 肯定比arrC里面所有的值都大所以使用
            $arrC[] = $arrA[0] < $arrB[0] ? array_shift($arrA) : array_shift($arrB);
        }

        return array_merge($arrC, $arrA, $arrB);
    }
}
