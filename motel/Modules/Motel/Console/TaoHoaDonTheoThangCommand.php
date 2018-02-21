<?php

namespace Modules\Motel\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;
use Modules\Motel\Entities\Bills;
use Modules\Motel\Entities\BillsDetail;
use Modules\Motel\Entities\Config;
use Modules\Motel\Entities\Bookings;

class TaoHoaDonTheoThangCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motel:create-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tu tao hoa don vao cuoi thang';   

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->line('System will...');
        //$currentUser = $this->auth->user()->id;
        $bookings = Bookings::all();
        foreach($bookings as $value){
                $now_month = Carbon::now()->format('Y-m');
                $this_month = Carbon::now()->format('m');
                $bill = Bills::where('user_id',$value->user_id)
                                ->whereRaw("DATE_FORMAT(created_at,'%Y-%m')='{$now_month}'")
                                ->where('booking_id',$value->id)
                                ->first();
                if(!$bill){
                    $bill = new Bills();
                    $bill->user_id = $value->user_id;
                    $bill->booking_id = $value->id;
                    $bill->created_at = Carbon::now();
                    $bill->save();

                    $bill_detail = new BillsDetail();
                    $bill_detail->user_id = $value->user_id;
                    $bill_detail->bills_id = $bill->id;
                    $bill_detail->created_at = Carbon::now();
                    $bill_detail->save();
                $this->info('Tao bill thanh cong');
            }
        }
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force the installation, even if already installed'],
        ];
    }
}
