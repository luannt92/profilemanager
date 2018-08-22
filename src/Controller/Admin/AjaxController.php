<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class AjaxController
 *
 * @package App\Controller\Admin
 */
class AjaxController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * getCategoryByService method
     **
     *
     * @param null $serviceId
     */
    public function getCategoryByService($serviceId = null)
    {
        /* @var \App\Model\Table\CategoriesTable $categoryObj */
        $categoryObj = TableRegistry::getTableLocator()->get('Categories');
        $conditions  = [
            'OR' => [
                'service_id' => $serviceId,
                'service_id IS NULL',
            ],
        ];
        $result      = $categoryObj->getListCategories([], $conditions);
        $html        = null;
        if ( ! empty($result)) {
            foreach ($result as $key => $value) {
                $html .= "<option value=\"{$key}\">{$value}</option>";
            }
        }

        echo json_encode([
            'success' => true,
            'html'    => $html,
        ]);
        die;
    }

    /**
     * getCategoryByStore method and generate sku store
     **
     *
     * @param null $storeId
     */
    public function getCategoryByStore($storeId = null)
    {
        /* @var \App\Model\Table\CategoriesTable $categoryObj */
        $categoryObj = TableRegistry::getTableLocator()->get('Categories');
        $result      = $categoryObj->getCategoryByStore($storeId, true);
        $html        = null;
        if ( ! empty($result)) {
            foreach ($result as $key => $value) {
                $html .= "<option value=\"{$key}\">{$value}</option>";
            }
        }

        /* @var \App\Model\Table\StoresTable $storeObj */
        $storeObj = TableRegistry::getTableLocator()->get('Stores');
        $sku      = $storeObj->getSkuByStore($storeId);

        echo json_encode([
            'success' => true,
            'html'    => $html,
            'sku'     => $sku,
        ]);
        die;
    }

    public function getCommision()
    {
        if ($this->request->is('post')) {
            $data     = $this->request->getData();
            $storeObj = TableRegistry::getTableLocator()->get('Stores');
            $store    = $storeObj->findById($data['data'])->first();

            echo json_encode([
                'commission' => $store->commission,
                'discount'   => $store->discount,
            ]);
            die;
        }
    }

    public function changeProduct()
    {
        if ($this->request->is('post')) {
            $data       = $this->request->getData();
            $productObj = TableRegistry::getTableLocator()->get('Products');
            $dataUpdate = [
                'name'     => $data['ajaxName'],
                'position' => $data['ajaxPosition'],
                'price'    => $data['ajaxPrice'],
            ];

            $returnUpdate = $productObj->updateAll($dataUpdate,
                ['id' => $data['ajaxId']]);

            if ($returnUpdate) {
                $dataRe = [
                    'message' => __('Cập nhật sản phẩm thành công'),
                    'status'  => true,
                ];
            } else {
                $dataRe = [
                    'message' => __('Cập nhật sản phẩm có lỗi. Vui lòng thử lại!'),
                    'status'  => false,
                ];
            }

            echo json_encode($dataRe);
            die;
        }
    }

    public function changeOrder()
    {
        if ($this->request->is('post')) {
            $data       = $this->request->getData();
            $dataUpdate = [];
            $orderObj   = TableRegistry::getTableLocator()->get('Orders');
            if ( ! empty($data['ajaxShippingZone'])) {
                $zoneObj    = TableRegistry::getTableLocator()
                    ->get('ShippingZones');
                $zone       = $zoneObj->findByName($data['ajaxShippingZone'])
                    ->first();
                $order      = $orderObj->findById($data['ajaxId'])->first();
                $dataUpdate = [
                    'fee_shipping' => $zone->price,
                    'payment_pay'  => $order->payment_total + $zone->price,
                ];
            }
            $dataUpdate = array_merge([
                'shipper_id'         => $data['ajaxShipper'],
                'shipper_commission' => $data['ajaxShipperCommission'],
                'area_order'         => $data['ajaxShippingZone'],
            ], $dataUpdate);

            $returnUpdate = $orderObj->updateAll($dataUpdate,
                ['id' => $data['ajaxId']]);

            if ($returnUpdate) {
                $dataRe = [
                    'message' => __('Cập nhật đơn hàng thành công'),
                    'status'  => true,
                ];
                $users  = $this->getEmailAdmin();
                if ($users['to'] != '') {
                    $mailTbl = TableRegistry::getTableLocator()
                        ->get('MailTemplates');
                    $mailTemplate
                             = $mailTbl->getMailTemplate(MAIL_TEMPLATE_ADD_SHIPPER);
                    $title   = str_replace('%shipper%', $data['name'],
                        $mailTemplate['subject']);
                    $title   = str_replace('%order%', $data['tracking'],
                        $title);
                    $content = str_replace('%username%',
                        $this->Auth->user('full_name'),
                        $mailTemplate['content']);
                    $content = str_replace('%order%', $data['tracking'],
                        $content);
                    $content = str_replace('%shipper%', $data['name'],
                        $content);
                    $content = str_replace('%commission%',
                        number_format($data['ajaxShipperCommission']),
                        $content);

                    $mailTbl->sendMail(
                        $title,
                        $content,
                        $users['to'],
                        $viewVarsOption = [],
                        $format = 'html',
                        $config = 'gmail',
                        $attachedFile = null,
                        $template = 'default',
                        $layout = 'default',
                        $users['cc']
                    );
                }

            } else {
                $dataRe = [
                    'message' => __('Cập nhật đơn hàng có lỗi. Vui lòng thử lại!'),
                    'status'  => false,
                ];
            }

            echo json_encode($dataRe);
            die;
        }
    }

    public function changeStore()
    {
        if ($this->request->is('post')) {
            $data       = $this->request->getData();
            $storeObj   = TableRegistry::getTableLocator()->get('Stores');
            $dataUpdate = [
                'position' => $data['ajaxPosition'],
            ];

            $returnUpdate = $storeObj->updateAll($dataUpdate,
                ['id' => $data['ajaxId']]);

            if ($returnUpdate) {
                $dataRe = [
                    'message' => __('Cập nhật sản phẩm thành công'),
                    'status'  => true,
                ];
            } else {
                $dataRe = [
                    'message' => __('Cập nhật sản phẩm có lỗi. Vui lòng thử lại!'),
                    'status'  => false,
                ];
            }

            echo json_encode($dataRe);
            die;
        }
    }

    public function changeHotel()
    {
        if ($this->request->is('post')) {
            $data       = $this->request->getData();
            $hotelObj   = TableRegistry::getTableLocator()->get('Hotels');
            $dataUpdate = [
                'shipping_zone_id' => $data['ajaxZoneId'],
                'status'           => $data['ajaxStatus'],
            ];

            $returnUpdate = $hotelObj->updateAll($dataUpdate,
                ['id' => $data['ajaxId']]);

            if ($returnUpdate) {
                $dataRe = [
                    'message' => __('Cập nhật khách sạn thành công'),
                    'status'  => true,
                ];
            } else {
                $dataRe = [
                    'message' => __('Cập nhật khách sạn có lỗi. Vui lòng thử lại!'),
                    'status'  => false,
                ];
            }

            echo json_encode($dataRe);
            die;
        }
    }

}
