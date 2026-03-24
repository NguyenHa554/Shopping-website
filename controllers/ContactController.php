<?php
defined('SONNE_APP') or die('No direct access');

class ContactController extends Controller {

    public function index(array $p): void {
        $pageContent = PageContentModel::allAsMap();
        $this->render('contact/index', compact('pageContent') + ['title' => 'Liên hệ – ' . APP_NAME], 'main');
    }

    public function submit(array $p): void {
        $this->validateCsrf();
        $name    = trim($_POST['full_name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
            $this->redirectWith('/contact', 'error', 'Vui lòng điền đầy đủ thông tin.');
            return;
        }

        ContactModel::create(compact('full_name', 'email', 'phone', 'subject', 'message') + ['full_name' => $name]);
        $this->redirectWith('/contact', 'success', 'Cảm ơn! Tin nhắn của bạn đã được gửi. Chúng tôi sẽ phản hồi sớm nhất.');
    }
}
