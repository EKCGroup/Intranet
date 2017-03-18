<?php defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($status as $status_item):
    switch ($status_item['status']) {
        case 0:
            $service_id = $status_item["id"];
            $service_status = 0;
            $this->status_model->log($service_id, $service_status);
            echo 'Down - ID=' . $status_item['id'] . ' NAME=' . $status_item['name'] . ' TIME=' . date('h:i') . ' DATE=' . date('Y-m-d') . '<br>';
            break;
        case 1:
            $service_id = $status_item["id"];
            $service_status = 1;
            $this->status_model->log($service_id, $service_status);
            echo 'Up - ID=' . $status_item['id'] . ' NAME=' . $status_item['name'] . ' TIME=' . date('h:i') . ' DATE=' . date('Y-m-d') . '<br>';
            break;
        case 2:
            $file = $status_item['url'];
            $file_headers = @get_headers($file);
            if ($file_headers || $file_headers[0] == 'HTTP/1.1 200 OK') {
                if ($status_item['auto_status'] === '0') {
                    //$this->email->from('noreply@intranet.cant-col.ac.uk', 'IT Service Status');
                    //$this->email->to('ns@canterburycollege.ac.uk');
                    //$this->email->cc('helpdesk@canterburycollege.ac.uk');
                    //$this->email->subject('IT Service Status Up - ' .$status_item['name']);
                    //$this->email->message('IT Service Status Up: ' . $status_item['name'] . '.  Time - '.date('h.i A') . ' - Date -' . date('Y-m-d'). '.');
                    //$this->email->send();
                    //$this->status_model->auto_update_timestamp($service_id);
                }
                $service_id = $status_item["id"];
                $service_status = 1;
                $this->status_model->auto_update_ok($service_id, $service_status);
                $this->status_model->log($service_id, $service_status);
                echo 'Up - ID=' . $status_item['id'] . ' NAME=' . $status_item['name'] . ' TIME=' . date('h:i') . ' DATE=' . date('Y-m-d') . '<br>';
            } else {
                if ($status_item['auto_status'] === '1') {
                    //$this->email->from('noreply@intranet.cant-col.ac.uk', 'IT Service Status');
                    //$this->email->to('ns@canterburycollege.ac.uk');
                    //$this->email->cc('helpdesk@canterburycollege.ac.uk');
                    //$this->email->subject('IT Service Status Down - ' .$status_item['name']);
                    //$this->email->message('IT Service Status Down: ' . $status_item['name'] . '. Time - '.date('h.i A') . ' - Date -' . date('Y-m-d'). '.');
                    //$this->email->send();
                    //$this->status_model->auto_update_timestamp($service_id);
                }
                $service_id = $status_item["id"];
                $service_status = 0;
                $this->status_model->auto_update_bad($service_id, $service_status);
                $this->status_model->log($service_id, $service_status);
                echo 'Down - ID=' . $status_item['id'] . ' NAME=' . $status_item['name'] . ' TIME=' . date('h:i') . ' DATE=' . date('Y-m-d') . '<br>';
            }
            break;
    }
endforeach;
