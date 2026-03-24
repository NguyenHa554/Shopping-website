<?php
defined('SONNE_APP') or die('No direct access');

class FaqController extends Controller {
    public function index(array $p): void {
        $faqs = FaqModel::allOrdered();
        $this->render('faq/index', compact('faqs') + ['title' => 'Hỏi & Đáp – ' . APP_NAME], 'main');
    }
}
