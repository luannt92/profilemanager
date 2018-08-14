<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * Class DashboardsController
 *
 * @package App\Controller\Admin
 */
class DashboardsController extends CommonController
{
    /*
     *  style common head of excel file
     */
    private $_styleHead
        = [
            'font'      => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

    /*
     * head for excel file
     */
    private $_zone
        = [
            -1         => [
                'title'   => 'Time',
                'rowspan' => 2,
            ],
            CANCEL     => [
                'title'   => 'Cancel',
                'colspan' => 'twoCol',
            ],
            PROCESSING => [
                'title'   => 'Processing',
                'colspan' => 'twoCol',
            ],
            CONFIRMED  => [
                'title'   => 'Confirmed',
                'colspan' => 'twoCol',
            ],
            SHIPPED    => [
                'title'   => 'Shipped',
                'colspan' => 'twoCol',
            ],
            RECEIVED   => [
                'title'   => 'Received',
                'colspan' => 'threeCol',
            ],
        ];

    private $_shipper
        = [
            [
                'title' => 'Time',
            ],
            [
                'title' => 'Name',
            ],
            [
                'title' => 'Email',
            ],
            [
                'title' => 'Phone',
            ],
            [
                'title' => 'Quantity',
            ],
            [
                'title' => 'Commission',
            ],
        ];

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * summary method
     *
     */
    public function summary()
    {
        $now         = Time::now();
        $time        = $now->toDateString();
        $condition   = ["YEAR(Orders.time)" => $now->year,];
        $total       = $this->_byFlot(FLOT_MONTH, $condition, [], $time);
        $totalIncome = $total['income'];
        $perIncome   = $total['perIncome'];
        $condition   = ["DATE_FORMAT(Orders.time,'%Y-%m-%d')" => $time];
        $order       = $this->_byFlot(FLOT_DAY, $condition, [], $time,
            [PROCESSING]);
        $orderNumber = $order['orderCurrent'];
        $perOrder    = $order['perOrderLast'];

        $userLogTbl = TableRegistry::get('UserLogs');
        $userLog    = $userLogTbl->reportUserLog($time);
        $userLogOld = $userLogTbl->reportUserLog($now->subDay()
            ->toDateString());
        $perUserLog = $this->_calculateOrder([$userLog, $userLogOld], true);

        $userTrackingTbl = TableRegistry::get('UserTrackings');
        $userTracking    = $userTrackingTbl->reportUserTracking($time);

        $this->set(compact('datas', 'totalIncome', 'perIncome', 'orderNumber',
            'perOrder', 'userLog', 'perUserLog', 'userTracking'));
    }

    /**
     * report method
     */
    public function report()
    {
        $now         = Time::now();
        $time        = $now->toDateString();
        $condition   = ["YEAR(Orders.time)" => $now->year,];
        $total       = $this->_byFlot(FLOT_MONTH, $condition, [], $time);
        $totalIncome = $total['income'];
        $perIncome   = $total['perIncome'];
        $condition   = ["DATE_FORMAT(Orders.time,'%Y-%m-%d')" => $time];
        $order       = $this->_byFlot(FLOT_DAY, $condition, [], $time,
            [PROCESSING]);
        $orderNumber = $order['orderCurrent'];
        $perOrder    = $order['perOrderLast'];

        $userLogTbl = TableRegistry::get('UserLogs');
        $userLog    = $userLogTbl->reportUserLog($time);
        $userLogOld = $userLogTbl->reportUserLog($now->subDay()
            ->toDateString());
        $perUserLog = $this->_calculateOrder([$userLog, $userLogOld], true);

        $userTrackingTbl = TableRegistry::get('UserTrackings');
        $userTracking    = $userTrackingTbl->reportUserTracking($time);

        $this->set(compact('datas', 'totalIncome', 'perIncome', 'orderNumber',
            'perOrder', 'userLog', 'perUserLog', 'userTracking'));
    }

    /**
     * flot ajax
     */
    public function flotAjax()
    {
        $result = ['data' => [], 'error' => null,];
        if ($this->request->is('post')) {
            $data      = $this->request->getData();
            $now       = Time::now();
            $time      = $now->toDateString();
            $condition = $select = $subCondition = $check = $conditionPer = [];
            $status    = [RECEIVED];

            if ($data['type'] == FLOT_DAY) {
                $condition = array_merge($condition, [
                    "DATE_FORMAT(Orders.time,'%Y-%m-%d')" => $time,
                ]);
            } elseif ($data['type'] == FLOT_MONTH) {
                $condition = array_merge($condition, [
                    "YEAR(Orders.time)" => $now->year,
                ]);
            }

            if ( ! empty($data['uid'])) {
                $subCondition = ['Orders.user_id' => $data['uid']];
            }

            if (isset($data['status']) && $data['status'] != null) {
                $status = [(int)$data['status']];
            }

            if ( ! empty($data['start_date'])) {
                if ($data['type'] == FLOT_MONTH) {
                    $time         = $data['start_date'];
                    $timeName     = 'DATE_FORMAT(Orders.time,"%Y-%m")';
                    $condition    = [$timeName . ' >=' => $time];
                    $conditionPer = [$timeName => $time];
                    $time         .= '-01';
                    $select
                                  = ['times' => 'DATE_FORMAT(Orders.time,"%Y-%m")'];
                } elseif ($data['type'] == FLOT_ANNUAL) {
                    $time         = $data['start_date'];
                    $timeName     = 'YEAR(Orders.time)';
                    $condition    = [$timeName . ' >=' => $time];
                    $conditionPer = [$timeName => $time];
                    $time         .= '-01-01';
                    $select       = [];
                } else {
                    $time         = $data['start_date'];
                    $timeName     = 'DATE_FORMAT(Orders.time,"%Y-%m-%d")';
                    $condition    = [$timeName => $time];
                    $conditionPer = [$timeName => $time];
                    $select       = [];
                }

                if ( ! empty($data['end_date'])) {
                    if ($data['type'] == FLOT_MONTH) {
                        $end = $data['end_date'] . '-01';
                    } else if ($data['type'] == FLOT_ANNUAL) {
                        $end = $data['end_date'] . '-01-01';
                    }
                    $check = $this->_generateTimeByDistance($time, $end,
                        $data['type']);
                    if (count($check) > FLOT_MONTH_DISTANCE_SEARCH
                        && $data['type'] == FLOT_MONTH
                    ) {
                        $result['error'] = __(USER_MSG_0063,
                            $data['start_date'], $data['end_date']);
                    }
                    $condition[$timeName . ' <='] = $data['end_date'];
                }
            } else {
                $conditionPer = $condition;
            }

            //data[profit] in js
            $profit = [];
            if ( ! empty($data['profit']) && $data['profit'] == 1) {
                $profit['profit'] = true;
            }

            /**@var \App\Model\Table\OrdersTable $orderTbl */
            $orderTbl       = TableRegistry::get('Orders');
            $datas          = $orderTbl->getDataOrderToFlot($data['type'],
                $condition, $select, $status, $subCondition, $profit);
            $result['data'] = ($data['type'] == FLOT_MONTH
                || $data['type'] == FLOT_ANNUAL)
                ? $this->_generateTimeEmptyForFlot($datas, $check) : $datas;
            $result         = array_merge($result,
                $this->_byFlot($data['type'], $conditionPer, $select, $time,
                    $status, $subCondition, $profit));
        }

        echo json_encode($result);
        die;
    }

    /**
     * get data flot by flot type
     *
     * @param       $by
     * @param array $condition
     * @param array $select
     * @param       $time
     * @param array $status
     * @param array $subCondition
     * @param bool  $profit
     *
     * @return mixed
     */
    public function _byFlot(
        $by,
        $condition = [],
        $select = [],
        $time,
        $status = [RECEIVED],
        $subCondition = [],
        $profit = []
    ) {
        /**@var \App\Model\Table\OrdersTable $orderTbl */
        $orderTbl = TableRegistry::get('Orders');
        $income   = $orderTbl->getDataOrderToFlot($by, $condition, $select,
            $status, $subCondition, $profit);
        $time     = Time::parse($time);

        if ($by == FLOT_MONTH) {
            $lastTime   = Time::parse($time->toDateString())->subMonth();
            $lastTime2  = Time::parse($time->toDateString())->subMonth(2);
            $condition  = [
                'DATE_FORMAT(Orders.time,"%Y-%m")' => $lastTime->format("Y-m"),
            ];
            $condition2 = [
                'DATE_FORMAT(Orders.time,"%Y-%m")' => $lastTime2->format("Y-m"),
            ];
        } else if ($by == FLOT_ANNUAL) {
            $lastTime   = Time::parse($time->toDateString())->subYear();
            $lastTime2  = Time::parse($time->toDateString())->subYear(2);
            $condition  = ['YEAR(Orders.time)' => $lastTime->year];
            $condition2 = ['YEAR(Orders.time)' => $lastTime2->year];
        } else {
            $lastTime  = Time::parse($time->toDateString())->subDay();
            $lastTime2 = Time::parse($time->toDateString())->subDay(2);
            $condition
                       = ["DATE_FORMAT(Orders.time,'%Y-%m-%d')" => $lastTime->toDateString()];
            $condition2
                       = ["DATE_FORMAT(Orders.time,'%Y-%m-%d')" => $lastTime2->toDateString()];
        }

        $orderLast       = $orderTbl->getDataOrderToFlot($by, $condition,
            $select, $status, $subCondition, $profit);
        $orderLast2      = $orderTbl->getDataOrderToFlot($by, $condition2,
            $select, $status, $subCondition, $profit);
        $orderLastIncome = $orderLast;
        if ($by == FLOT_DAY) {
            $result['income'] = $this->_calculateOrder([$income]);
            $orderLastIncome  = $this->_calculateOrder([$orderLast]);
            $orderCurrent     = $this->_calculateOrder([$income], false,
                'quantity');
            $orderLast        = $this->_calculateOrder([$orderLast],
                false, 'quantity');
            $orderLast2       = $this->_calculateOrder([$orderLast2],
                false, 'quantity');

        } else {
            $timeCurrent = ['last' => $lastTime->year, 'now' => $time->year,];
            $timeLast    = [
                'last' => $lastTime2->year,
                'now'  => $lastTime->year,
            ];
            $timeLast2   = [
                'last' => $lastTime2->year - 1,
                'now'  => $lastTime2->year,
            ];
            if ($by == FLOT_MONTH) {
                $timeCurrent = [
                    'last' => $lastTime->month,
                    'now'  => $time->month,
                ];
                $timeLast    = [
                    'last' => $lastTime2->month,
                    'now'  => $lastTime->month,
                ];
                $timeLast2   = [
                    'last' => $lastTime2->month - 1,
                    'now'  => $lastTime2->month,
                ];
            }
            $result['income'] = $this->_getLastOrder($by, $income,
                $timeCurrent);
            $orderCurrent     = $this->_getLastOrder($by, $income, $timeCurrent,
                false, [], 'quantity');
            $orderLast        = $this->_getLastOrder($by, $orderLast, $timeLast,
                false, [], 'quantity');
            $orderLast2       = $this->_getLastOrder($by, $orderLast2,
                $timeLast2, false, [], 'quantity');
            $orderLastIncome  = $this->_getLastOrder($by, $orderLastIncome,
                $timeLast);
        }
        $result['perIncome'] = $this->_calculateOrder(
            [$result['income'], $orderLastIncome,], true
        );

        $result['orderCurrent']  = $orderCurrent;
        $result['perOrderLast']  = $this->_calculateOrder(
            [$orderCurrent, $orderLast,], true
        );
        $result['perOrderLast2'] = $this->_calculateOrder(
            [$orderLast, $orderLast2,], true
        );
        $result['orderLast']     = $orderLast;

        return $result;
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
        $userTbl = TableRegistry::get('Users');
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

    public function zone()
    {
        /**@var \App\Model\Table\ShippingZonesTable $shippingZoneObj */
        $shippingZoneObj = TableRegistry::get('ShippingZones');
        $zones           = $shippingZoneObj->getShippingZones([], true, [
            'keyField'   => 'name',
            'valueField' => 'name',
        ]);
        $typeTime        = FLOT_DAY;
        $search          = [];

        if ($this->request->is('post')) {
            $search               = $this->request->getData();
            $reportType['profit'] = true;
            $reportType['zone']   = true;
            $typeTime             = empty($search['type']) ? FLOT_DAY
                : $search['type'];
            $status               = [
                CANCEL,
                PROCESSING,
                CONFIRMED,
                SHIPPED,
                RECEIVED,
            ];
            $condition            = [
//                'Orders.address_type' => HOTEL,
            ];
            $condition            = $this->_searchFiltersCondition($condition,
                $search);

            $select = [
                'Orders.status',
                'priceOrders' => 'SUM(Orders.payment_pay)',
                'feeShipping' => 'SUM(Orders.fee_shipping)',
            ];
            $group  = ['Orders.status'];

            /**@var \App\Model\Table\OrdersTable $orderObj */
            $orderObj = TableRegistry::get('Orders');
            $orders   = $orderObj->getDataOrderToFlot($typeTime, $condition,
                $select, $status, [], $reportType, [], $group);

            $items = $this->_allStatusReport($orders);
        }

        $this->set(compact('zones', 'typeTime', 'items', 'search'));
    }

    /**
     *  export file excel: Report zone
     */
    public function excelZone()
    {
        if ($this->request->is('post')) {
            $search    = $this->request->getData();
            $typeTime  = empty($search['type']) ? FLOT_DAY : $search['type'];
            $status    = [CANCEL, PROCESSING, CONFIRMED, SHIPPED, RECEIVED];
            $condition = [
//                'Orders.address_type' => HOUSE,
            ];
            $condition = $this->_searchFiltersCondition($condition, $search);

            $select = [
                'Orders.status',
                'priceOrders' => 'SUM(Orders.payment_pay)',
            ];
            $group  = ['Orders.status'];

            /**@var \App\Model\Table\OrdersTable $orderObj */
            $orderObj = TableRegistry::get('Orders');
            $orders   = $orderObj->getDataOrderToFlot($typeTime, $condition,
                $select, $status, [], ['profit'], [], $group);

            //get all status of orders data
            $items    = $this->_allStatusReport($orders);
            $heads    = $this->_zone;
            $datas    = [];
            $index    = 1;
            $twoCol   = [
                __('Quantity'),
                __('Total price'),
            ];
            $threeCol = [
                __('Quantity'),
                __('Total price'),
                __('Profit'),
            ];

            // set head for spreadsheet
            foreach ($heads as $head) {
                if ( ! empty($head['colspan'])) {
                    $cols = $head['colspan'];
                    foreach ($$cols as $col) {
                        $datas[$index - 1][] = __($head['title']);
                        $datas[$index][]     = $col;
                    }
                } else {
                    $datas[$index - 1][] = __($head['title']);
                }

                if ( ! empty($head['rowspan'])) {
                    for ($i = 1; $i < $head['rowspan']; $i++) {
                        $datas[$index][] = __($head['title']);
                    }
                }
            }
            // set data for each row
            foreach ($items as $key => $item) {
                ++$index;
                $datas[$index][] = $key;
                foreach ($item as $keyItems => $value) {
                    $datas[$index][] = $value['quantity'];
                    $datas[$index][] = $value['priceOrders'];
                    if ($keyItems == RECEIVED) {
                        $datas[$index][] = $value['price'];
                    }
                }

            }

            // setting coordinate spreadsheet
            $mergeCells     = [
                'A1:A2',
                'B1:C1',
                'D1:E1',
                'F1:G1',
                'H1:I1',
                'J1:L1',
            ];
            $coordinateHead = 'A1:L2';
            $time           = Time::now()->getTimestamp();
            $nameFile       = __(TITLE_EXPORT_EXCEL, 'Zone') . '_' . $time;
            $styleHeads     = $this->_styleHead;

            $this->exportExcel($nameFile, $datas, $mergeCells, $coordinateHead,
                $styleHeads, range('A', 'L'));
        }
        exit();
    }

    /**
     * - generate all status by data
     *  If any status does not exit in data, it will push array template.
     * - pushing sum the lines (by vertical) at the end array
     *
     * @param array $datas
     *
     * @return array
     */
    public function _allStatusReport($datas = [])
    {
        $items  = $arrSum = [];
        $status = [CANCEL, PROCESSING, CONFIRMED, SHIPPED, RECEIVED];

        if ( ! empty($datas)) {
            foreach ($datas as $data) {
                foreach ($status as $stt) {
                    if ($data['status'] == $stt) {
                        $items[$data['times']][$stt] = $data;
                    } else {
                        if (empty($items[$data['times']][$stt])) {
                            $items[$data['times']][$stt] = [
                                'quantity'    => 0,
                                'times'       => $data['times'],
                                'status'      => $stt,
                                'priceOrders' => 0,
                                'price'       => 0,
                                'feeShipping' => 0,
                            ];
                        }
                    }
                }
            }
        }

        // calculate sum the line (by vertical)
        foreach ($status as $stt) {
            $arrSum[$stt]['quantity']
                = array_sum(array_column(array_column($items,
                $stt), 'quantity'));
            $arrSum[$stt]['priceOrders']
                = array_sum(array_column(array_column($items,
                $stt), 'priceOrders'));
            $arrSum[$stt]['price']
                = array_sum(array_column(array_column($items,
                $stt), 'price'));
            $arrSum[$stt]['feeShipping']
                = array_sum(array_column(array_column($items,
                $stt), 'feeShipping'));

        }

        $items[__('Total')] = $arrSum;

        return $items;
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

    public function shipper()
    {
        /**@var \App\Model\Table\ShippersTable $shipperObj */
        $shipperObj = TableRegistry::get('Shippers');
        $shippers   = $shipperObj->getShippers([], true, [
            'keyField'   => 'id',
            'valueField' => function ($e) {
                $data = empty($e['name']) ? '' : $e['name'];
                $data .= empty($e['phone']) ? ''
                    : '  [' . $e['phone'] . ']';

                return $data;
            },
        ]);
        $typeTime   = FLOT_DAY;
        $search     = [];

        if ($this->request->is('post')) {
            $search                = $this->request->getData();
            $reportType['shipper'] = true;
            $typeTime              = empty($search['type']) ? FLOT_DAY
                : $search['type'];
            $status                = [RECEIVED];
            $condition             = [];
            $condition             = $this->_searchFiltersCondition($condition,
                array_merge($search, ['shipperType' => true]));

            $select = [
                'name'  => 'Shippers.name',
                'email' => 'Shippers.email',
                'phone' => 'Shippers.phone',
            ];
            $group  = ['Orders.shipper_id'];

            /**@var \App\Model\Table\OrdersTable $orderObj */
            $orderObj = TableRegistry::get('Orders');
            $items    = $orderObj->getDataOrderToFlot($typeTime, $condition,
                $select, $status, [], $reportType, [], $group);
        }

        $this->set(compact('shippers', 'typeTime', 'items', 'search'));
    }

    /**
     *  export file excel: Report shipper
     */
    public function excelShipper()
    {
        if ($this->request->is('post')) {
            $search                = $this->request->getData();
            $reportType['shipper'] = true;
            $typeTime              = empty($search['type']) ? FLOT_DAY
                : $search['type'];
            $status                = [RECEIVED];
            $condition             = [];
            $condition             = $this->_searchFiltersCondition($condition,
                array_merge($search, ['shipperType' => true]));

            $select = [
                'name'  => 'Shippers.name',
                'email' => 'Shippers.email',
                'phone' => 'Shippers.phone',
            ];
            $group  = ['Orders.shipper_id'];

            /**@var \App\Model\Table\OrdersTable $orderObj */
            $orderObj = TableRegistry::get('Orders');
            $items    = $orderObj->getDataOrderToFlot($typeTime, $condition,
                $select, $status, [], $reportType, [], $group);
            $heads    = $this->_shipper;
            $datas    = [];
            $index    = 0;

            // set head for spreadsheet
            foreach ($heads as $head) {
                $datas[$index][] = __($head['title']);
            }

            // set data for each row
            foreach ($items as $key => $item) {
                ++$index;
                foreach ($item as $keyItems => $value) {
                    $datas[$index][] = $value;
                }
            }

            // setting coordinate spreadsheet
            $coordinateHead = 'A1:F1';
            $time           = Time::now()->getTimestamp();
            $nameFile       = __(TITLE_EXPORT_EXCEL, 'Shipper') . '_' . $time;
            $styleHeads     = $this->_styleHead;

            $this->exportExcel($nameFile, $datas, [], $coordinateHead,
                $styleHeads, range('A', 'F'));
        }
        exit();
    }

    public function reportShipping()
    {
        $typeTime = FLOT_DAY;
        $search   = $items = [];

        if ($this->request->is('post')) {
            $search                 = $this->request->getData();
            $reportType['profit']   = true;
            $reportType['shipping'] = true;
            $typeTime               = empty($search['type']) ? FLOT_DAY
                : $search['type'];
            $status                 = [RECEIVED];

            $condition = $this->_searchFiltersCondition([], $search);

            $select = [
                'Orders.status',
                'priceOrders'       => 'SUM(Orders.payment_pay)',
                'feeShipping'       => 'SUM(Orders.fee_shipping)',
                'shipperCommission' => 'SUM(Orders.shipper_commission)',
            ];
            $group  = ['Orders.status'];

            /**@var \App\Model\Table\OrdersTable $orderObj */
            $orderObj = TableRegistry::get('Orders');
            $orders   = $orderObj->getDataOrderToFlot($typeTime, $condition,
                $select, $status, [], $reportType, [], $group);
            $items    = $this->_calculatorTotalRecord($orders);

        }

        $this->set(compact('typeTime', 'items', 'search'));
    }

    /**
     * emptyDataReport method
     *
     * @param $times
     * @param $stt
     *
     * @return array
     * @author: diennt@antkoders.com
     */
    private function _emptyDataReport($times, $stt)
    {
        return [
            'quantity'          => 0,
            'times'             => $times,
            'status'            => $stt,
            'priceOrders'       => 0,
            'price'             => 0,
            'feeShipping'       => 0,
            'shipperCommission' => 0,
        ];
    }

    /**
     * _calculatorTotalRecord method
     *
     * @param array $orders
     *
     * @return array
     * @author: diennt@antkoders.com
     */
    private function _calculatorTotalRecord($orders = [])
    {
        $items  = $arrSum = [];
        $status = [RECEIVED];

        if ( ! empty($orders)) {
            foreach ($orders as $data) {
                foreach ($status as $stt) {
                    if ($data['status'] == $stt) {
                        $items[$data['times']][$stt] = $data;
                    } else {
                        if (empty($items[$data['times']][$stt])) {
                            $items[$data['times']][$stt]
                                = $this->_emptyDataReport($data['times'],
                                $stt);
                        }
                    }
                }
            }
        }

        // calculate sum the line (by vertical)
        foreach ($status as $stt) {
            $arrSum[$stt]['quantity']
                = array_sum(array_column(array_column($items,
                $stt), 'quantity'));
            $arrSum[$stt]['priceOrders']
                = array_sum(array_column(array_column($items,
                $stt), 'priceOrders'));
            $arrSum[$stt]['price']
                = array_sum(array_column(array_column($items,
                $stt), 'price'));
            $arrSum[$stt]['feeShipping']
                = array_sum(array_column(array_column($items,
                $stt), 'feeShipping'));
            $arrSum[$stt]['shipperCommission']
                = array_sum(array_column(array_column($items,
                $stt), 'shipperCommission'));
        }

        $items[__('Total')] = $arrSum;

        return $items;
    }
}
