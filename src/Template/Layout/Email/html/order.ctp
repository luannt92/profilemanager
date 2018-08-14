<!DOCTYPE html>
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }

        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6;
            color: #252525;
        }

        table td {
            vertical-align: middle;
        }

        table td h3 {
            font-weight: normal;
        }

        body {
            background-color: #f2f2f2;
        }

        .body-wrap {
            background-color: #f2f2f2;
            width: 100%;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }

        .main {
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }

        .content-wrap {
            padding: 0 20px;
        }

        .content-block {
            padding: 15px 8px;
        }

        .order {
            border: 1px solid #eeeeee;
        }

        a {
            color: #e7272d;
            text-decoration: underline;
        }

        .btn-primary {
            text-decoration: none;
            color: #FFF;
            background-color: #e7272d;
            border: solid #e7272d;
            border-width: 7px 20px;
            line-height: 2;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
            text-transform: capitalize;
        }

        @media only screen and (max-width: 640px) {
            .container {
                width: 100% !important;
            }

            .content, .content-wrap {
                padding: 10px !important;
            }
        }

        table.table-content {
            border-spacing: 0px 20px;
        }

        .text-notification {
            text-align: center;
            color: #ea212e;
        }

        .content-block h3 {
            float: left;
            width: 33%;
            color: #ea212e;
            font-weight: normal;
        }

        .content-block h3 p {
            color: #141414;
        }

        .list div {
            float: left;
        }

        .product {
            width: 80%;
        }

        .product p.note {
            color: #888888;
        }

        .money {
            width: 20%;
        }

        p.active {
            color: #ea212e;
            font-weight: normal;
            display: inline-block;
        }
    </style>
</head>
<body>
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0"
                       cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <?= $this->fetch('content') ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>