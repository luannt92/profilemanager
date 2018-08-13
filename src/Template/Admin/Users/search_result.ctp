<?php echo $this->element('Admin/breadcrumb', [
    'title'    => 'Search Page',
    'subTitle' => 'Result',
]); ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h2>
                        0 results found for: <span
                                class="text-navy">“<?php echo $_GET['top-search']; ?>
                            ”</span>
                    </h2>
                    <small>Request time (0.23 seconds)</small>

                    <div class="search-form">

                    </div>
                    <div class="hr-line-dashed"></div>

                </div>
            </div>
        </div>
    </div>
</div>