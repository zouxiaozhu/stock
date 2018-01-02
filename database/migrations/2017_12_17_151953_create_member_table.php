<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createMember();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    protected function createMember(){
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('source',[1,2])->comment('来源 1 微信 2 facebook');
            $table->string('email')->default('');
            $table->string('signature')->comment('个性签名')->default('');
            $table->integer('phone')->default(0);
            $table->enum('status', [0, 1])->comment('状态，0禁用，1活跃')->default(1);
            $table->enum('is_post', [0, 1])->comment('状态，0不能发，1能发贴')->default(1);
            $table->string('open_id')->default('')->comment("")->index();
            $table->string('last_login_time')->default(date("Y-m-d,H:i:s",time()));
            $table->string('avatar')->default('');
            $table->string('rc_token')->comment('融云')->index()->default('');
            $table->timestamps();
        });
    }

    /***
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('1', '1', '1', '1', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('2', '1', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('3', '3', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('4', '4', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('5', '5', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('6', '67', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('7', '8', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('8', '8', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('9', '432', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('10', '23', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('11', '423', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('12', '2', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('13', '546', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('14', '7', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('15', '876', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('16', '867', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('17', '7867907', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('18', '635', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('19', '7678', NULL, '', '2', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('20', '9789', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('21', '63', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('22', '67960', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('23', '98795', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('24', '3463', NULL, '', '2', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('25', '67969', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('26', '4636', NULL, '', '2', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('27', '6', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('28', '678', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('29', '6', NULL, '', '2', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('30', '5', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('31', '678970', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('32', '7', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('33', '70', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('34', '780', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('35', '5', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('36', '785', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('37', '67978947', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('38', '4', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('39', '756869', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);
    INSERT INTO `stock`.`stock_members` (`id`, `name`, `password`, `nick_name`, `source`, `email`, `credits`, `type`, `group_id`, `signature`, `phone`, `status`, `open_id`, `last_login_time`, `avatar`, `last_login_device_type`, `created_at`, `updated_at`) VALUES ('40', '2', NULL, '', '1', '', '0', '1', '0', '', '0', '1', '', '2017-12-24,02:30:20', '', '', NULL, NULL);



     */
}
