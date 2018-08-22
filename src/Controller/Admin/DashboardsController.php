<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Class DashboardsController
 *
 * @package App\Controller\Admin
 */
class DashboardsController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     *  calculate order
     *
     * @param array  $orders
     * @param bool   $percent
     * @param string $field
     *
     * @return array|float|int|mixed
     */
    public function _calculateOrder(
        $orders = [],
        $percent = false,
        $field = 'price'
    ) {
        $params = [];
        if ( ! empty($orders)) {
            foreach ($orders as $order) {
                if (is_array($order) && ! empty($order)) {
                    $params[] = array_sum(array_column($order, $field));
                } else {
                    $params[] = empty($order) ? 0 : $order;
                }
                if (count($orders) === 1) {
                    $params = $params[0];
                }
            }

            if ($percent) {
                $p1 = empty($params[0]) ? 0 : $params[0];
                $p2 = empty($params[1]) ? 0 : $params[1];

                $params = $p2 === 0 ? 0 : round((($p1 - $p2) / $p2) * 100, 1);
            }
        }

        return $params;
    }

    /**
     * get last order
     *
     * @param        $by
     * @param        $pram1
     * @param array  $time
     * @param bool   $percent
     * @param array  $pram2
     * @param string $field
     *
     * @return array|float|int|mixed
     */
    public function _getLastOrder(
        $by,
        $pram1,
        $time = [],
        $percent = false,
        $pram2 = [],
        $field = 'price'
    ) {
        $lastInt    = $time['last'];
        $currentInt = $time['now'];
        $current    = end($pram1);
        $last       = end($pram2);

        if ($by == FLOT_MONTH) {
            $time             = new Time($current['times']);
            $current['times'] = $time->month;
            if ( ! empty($last)) {
                $time          = new Time($last['times']);
                $last['times'] = $time->month;
            }
        }

        $current = ( ! empty($current) && $current['times'] == $currentInt
            && isset($current[$field]))
            ? $current[$field] : 0;

        $last = ( ! empty($last) && $last['times'] == $lastInt
            && isset($current[$field]))
            ? $last[$field] : 0;


        return $percent ? $this->_calculateOrder([$current, $last], true)
            : $current;
    }

    /**
     * report customer
     */
    public function customer()
    {
        /**@var \App\Model\Table\UsersTable $userTbl */
        $userTbl = TableRegistry::getTableLocator()->get('Users');
        $users   = $userTbl->getAllUsers(['user_group_id' => MEMBER], true,
            [
                'keyField'   => 'id',
                'valueField' => function ($e) {
                    $data = empty($e['full_name']) ? '' : $e['full_name'];
                    $data .= empty($e['email']) ? ''
                        : '  [' . $e['email'] . ']';

                    return $data;
                },
            ]);

        $this->set(compact('users'));
    }

    /**
     * generate all time form ... to ...
     *
     * @param      $min
     * @param      $max
     * @param int  $type
     * @param bool $count
     *
     * @return array|int
     */
    public function _generateTimeByDistance(
        $min,
        $max,
        $type = FLOT_DAY,
        $count = false
    ) {
        $array = [];
        if ($type == FLOT_MONTH) {
            $format = 'Y-m';
        } elseif ($type == FLOT_ANNUAL) {
            $format = 'Y';
        } else {
            $format = 'Y-m-d';
        }

        $min = Time::parse($min)->format($format);
        $max = Time::parse($max)->format($format);
        while ($min !== $max) {
            $array[] = $min;
            if ($type == FLOT_MONTH) {
                $min = Time::parse($min . '-01')->addMonth()->format($format);
            } else if ($type == FLOT_ANNUAL) {
                $min = Time::parse($min . '-01-01')->addYear()->format($format);
            } else {
                $min = Time::parse($min)->addDay()->format($format);
            }
        }

        $array[] = $max;

        if ($count) {
            return count($array);
        }

        return $array;
    }

    /**
     * generate time has empty data for flot
     *
     * @param array $datas
     * @param array $times
     *
     * @return array
     */
    public function _generateTimeEmptyForFlot($datas = [], $times = [])
    {
        $arrayEmpty = [];
        if ( ! empty($datas)) {
            $arraySame = [];
            foreach ($datas as $data) {
                $arraySame[] = $data['times'];
            }
            $times = array_diff($times, $arraySame);
        }

        if ( ! empty($times)) {
            foreach ($times as $time) {
                $arrayEmpty[] = [
                    'price'    => 0,
                    'quantity' => 0,
                    'times'    => $time,
                ];
            }
        }
        $array = array_merge($datas, $arrayEmpty);

        return $array;
    }


    /**
     * profit method
     */
    public function profit()
    {
        //TODO: report profit of order
    }

    /**
     * search function
     *
     * @param       $conditions
     * @param array $params
     *
     * @return mixed
     */
    public function _searchFiltersCondition($conditions, $params = [])
    {
        $now  = Time::now();
        $time = $now->toDateString();

        if ( ! empty($params['zone'])) {
            // search with condition unassigned area
            if ($params['zone'] == -1) {
                $conditions['Orders.area_order'] = '';
            } else {
                $conditions['Orders.area_order'] = $params['zone'];
            }
        }

        if ( ! empty($params['start_date'])) {
            $time = $params['start_date'];
            if ($params['type'] == FLOT_MONTH) {
                $timeName = 'DATE_FORMAT(Orders.time,"%Y-%m")';
            } elseif ($params['type'] == FLOT_ANNUAL) {
                $timeName = 'YEAR(Orders.time)';
            } else {
                $timeName = 'DATE_FORMAT(Orders.time,"%Y-%m-%d")';
            }
            $conditions[$timeName . ' >='] = $time;

            if ( ! empty($params['end_date'])) {
                $conditions[$timeName . ' <='] = $params['end_date'];
            } else {
                $conditions[$timeName . ' <='] = $now->toDateString();
            }

        } else {
            if ($params['type'] == FLOT_DAY) {
                $conditions["DATE_FORMAT(Orders.time,'%Y-%m-%d')"] = $time;
            } elseif ($params['type'] == FLOT_MONTH) {
                $conditions["YEAR(Orders.time)"] = $now->year;
            }
        }

        // change alias table
        if (isset($params['shipperType'])) {
            $conditionTemp = [];
            foreach ($conditions as $key => $condition) {
                $keyChange                 = str_replace('Orders.time',
                    'OH.time', $key);
                $conditionTemp[$keyChange] = $condition;
            }

            $conditions = $conditionTemp;
        }

        if ( ! empty($params['shipper'])) {
            $conditions['Orders.shipper_id'] = $params['shipper'];
        }

        return $conditions;
    }

    /**
     * report order by status
     */
    public function reportOrder()
    {
        //TODO: report order by status
    }
}
