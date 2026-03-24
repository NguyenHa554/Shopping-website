<?php
defined('SONNE_APP') or die('No direct access');

class FaqModel extends Model {
    protected static string $table = 'faqs';

    public static function allOrdered(): array {
        return DB::fetchAll("SELECT * FROM faqs ORDER BY sort_order, id");
    }
}
