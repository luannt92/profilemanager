<?php
namespace App\Shell;
use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
define('TABLE_PREFIX', 'pqd_');
define('MAIL_TEMPLATE_BIRTHDAY', 'TPL0008');
define('DEACTIVE', 0);
define('ENABLED', 1);
class BirthdayShell extends Shell {
    //0 2 * * * /usr/bin/php bin/cake.php birthday;
    function main(...$args)
    {
        $this->send_mail();
    }

    function send_mail()
    {
        $day = date('j');
        $month = date('n');
        $arrDays = Cache::read('birthday_' . $month, 'birthday');
        if(in_array($day, $arrDays))
        {
            $emailQueueTbl = TableRegistry::get('MailQueues');
            $query = $emailQueueTbl->find('all', [
                'conditions' => [
                    'day(birthday)' => $day
                ],
            ]);
            if($query->count() > 0)
            {
                $mailObj = TableRegistry::get('MailTemplates');
                $mailTemplate = $mailObj->getMailTemplate(MAIL_TEMPLATE_BIRTHDAY);
                foreach($query as $item)
                {
                    $user = $item->name == '' ? $item->email : $item->name;
                    $content = str_replace('%user%', $user, $mailTemplate['content']);
                    $result = $mailObj->sendMail(
                        $mailTemplate['subject'],
                        $content,
                        $item->email
                    );
                    if($result)
                    {
                        $emailQueueTbl->delete($item);
                    }
                }

            }
        }
    }
    //0 0 1 * * /usr/bin/php bin/cake.php birthday init;
    function init()
    {
        $month = date('n');
        $this->out($month);
        $userTbl = TableRegistry::get('Users');
        $query = $userTbl->find('all', [
            'conditions' => [
                'month(birthday)' => $month
            ],
            'fields' => ['email', 'full_name', 'birthday']
        ]);
        if($query->count() > 0)
        {
            $arrDays = [];
            $users = [];
            foreach ($query as $item)
            {
                $time = strtotime($item->birthday);
                $dateOfBirth = date('j', $time);
                if(!in_array($dateOfBirth, $arrDays))
                {
                    $arrDays[] = $dateOfBirth;
                }
                $users[] = [
                    'name' => $item->full_name,
                    'email' => $item->email,
                    'birthday' => date('Y-m-d', $time),
                    'status' => 0
                ];
            }
            $emailQueueTbl = TableRegistry::get('MailQueues');
            $entities = $emailQueueTbl->newEntities($users);
            $emailQueueTbl->saveMany($entities);
            Cache::write('birthday_' . $month, $arrDays, 'birthday');
        }
    }
}