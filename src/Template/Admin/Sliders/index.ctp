<?php echo $this->element('Admin/breadcrumb', [
    'title' => __(SLIDER_MANAGEMENT),
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <?php echo $this->element('Admin/boxSearch'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox toggleSpinners">
                <div class="ibox-content">
                    <?php echo $this->element('Admin/selectedAll', compact('search')); ?>
                   <div class="table-responsive">
                       <table class="footable table table-stripped toggle-arrow-tiny">
                           <thead>
                           <tr>
                               <th data-sort-ignore="true"><input type="checkbox" name="select_all" id="select_all" value=""/></th>
                               <th data-hide="all"><?php echo $this->Paginator->sort('id') ?></th>
                               <th data-toggle="true"><?php echo $this->Paginator->sort('title') ?></th>
                               <th scope="col"><?php echo $this->Paginator->sort('image') ?></th>
                               <th scope="col"><?php echo $this->Paginator->sort('type') ?></th>
                               <th scope="col"><?php echo $this->Paginator->sort('language') ?></th>
                               <th data-hide="all"><?php echo $this->Paginator->sort('description') ?></th>
                               <th data-hide="all"><?php echo $this->Paginator->sort('url') ?></th>
                               <th scope="col"><?php echo $this->Paginator->sort('position') ?></th>
                               <th scope="col"><?php echo $this->Paginator->sort('status') ?></th>
                               <th data-hide="all"><?php echo $this->Paginator->sort('created_at') ?></th>
                               <th data-hide="all"><?php echo $this->Paginator->sort('updated_at') ?></th>
                               <th data-sort-ignore="true"
                                   class="actions text-right"><?php echo __('Actions') ?></th>
                           </tr>
                           </thead>
                           <tbody>
                           <?php foreach ($items as $item):
                               $statusName = '';
                               $statusClass = '';
                               if ( ! empty($status[$item->status])) {
                                   $statusName  = $status[$item->status]['name'];
                                   $statusClass = $status[$item->status]['class'];
                               } ?>
                               <tr>
                                   <td><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $item->id; ?>"/></td>
                                   <td><?php echo $this->Number->format($item->id) ?></td>
                                   <td><?php echo h($item->title) ?></td>
                                   <td><img src="<?php echo h($item->image) ?>" id="previewImg" style="max-width: 80px; max-height :80px;" alt="">
                                   </td>
                                   <td><i class="<?php echo $sliderType[$item->type]['class']?>"></i>
                                   <td><?php echo $item->language; ?></td>
                                   <td><?php echo h($item->description) ?></td>
                                   <td><?php echo h($item->url) ?></td>
                                   <td><?php echo h($item->position) ?></td>
                                   <td>
                                       <span class="label <?php echo $statusClass; ?>"><?php echo $statusName; ?></span>
                                   </td>
                                   <td><?php echo h($item->created_at) ?></td>
                                   <td><?php echo h($item->updated_at) ?></td>
                                   <td class="text-right footable-visible footable-last-column tooltip-demo">
                                       <div class="btn-group">
                                           <?php echo $this->Html->link('<i class="fa fa-eye"></i>',
                                               ['action' => 'view', $item->id],
                                               [
                                                   'class'          => 'btn-white btn btn-xs',
                                                   'escape'         => false,
                                                   'data-toggle'    => "tooltip",
                                                   'data-placement' => "top",
                                                   'title'          => __(VIEW_TEXT),
                                               ]
                                           ); ?>
                                           <?php echo $this->Html->link('<i class="fa fa-edit"></i>',
                                               ['action' => 'edit', $item->id],
                                               [
                                                   'class'          => 'btn-white btn btn-xs',
                                                   'escape'         => false,
                                                   'data-toggle'    => "tooltip",
                                                   'data-placement' => "top",
                                                   'title'          => __(EDIT_TEXT),
                                               ]) ?>
                                           <?php echo $this->Form->postLink('<i class="fa fa-times"></i>',
                                               ['action' => 'delete', $item->id],
                                               [
                                                   'confirm'        => __(USER_MSG_0011,
                                                       $item->title),
                                                   'class'          => 'btn-white btn btn-xs',
                                                   'escape'         => false,
                                                   'data-toggle'    => "tooltip",
                                                   'data-placement' => "top",
                                                   'title'          => __(DELETE_TEXT),
                                               ]); ?>
                                       </div>
                                   </td>
                               </tr>
                           <?php endforeach; ?>
                           </tbody>
                           <tfoot>
                           <tr>
                               <td colspan="8" class="footable-visible">
                                   <?php echo $this->element('Admin/paginator'); ?>
                               </td>
                           </tr>
                           </tfoot>
                       </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
