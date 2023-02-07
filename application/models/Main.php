<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Model
{
    public function index()
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $today = $now->format('F d, Y');
        $tomorrow = new DateTime('tomorrow', new DateTimeZone('Asia/Manila'));
        $difference = $now->diff($tomorrow);
        $seconds = $difference->format('%s');
        $hours = $difference->format('%h') * 60 * 60;
        $remain = $hours + $seconds;
        $view_data['now'] = $today;
        $view_data['remain'] = $remain;
        $this->load->view('Countdown/index', $view_data);
    }
}

?>