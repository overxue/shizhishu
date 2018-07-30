<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Overtrue\EasySms\EasySms;
use Exception;

class VerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $code;
    //最大重试次数
//    public $tries = 3;
    //队列超时时间
//    public $timeout = 60;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            app(EasySms::class)->send($this->phone, [
                'template' => 'SMS_140725708',
                'data' => [
                    'code' => $this->code
                ],
            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            throw new Exception($message ?? '短信发送异常');
//            return $message ?? '短信发送异常';
        }
    }
}
