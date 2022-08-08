<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\ProductBestSeller;
use Illuminate\Support\Facades\DB;

class bestSellersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {

        $datas = DB::connection('oracle')->select('select prd_id,prd_nm from (SELECT m.prd_id, m.prd_nm,sum(d.ord_cost) as disp_seq from prd_prd_m m inner join ord_ord_dtl_d d on m.prd_id = d.prd_id and m.prd_ptr_cd = :a inner join ord_ord_sts_chg_h h on d.ord_id = h.ord_id and d.ord_ptr_cd in (:b) and d.ord_seq = h.ord_seq and d.ord_sts_cd = :c and h.ord_dtl_sts_cd = :d and m.prd_nm not like :e and h.ord_sts_dtm between to_date(to_char(sysdate - 7, :f), :f) and to_date(to_char(sysdate - 1, :f), :f) + 0.99999 group by m.prd_id,m.prd_nm) order by disp_seq desc',['a' => '10', 'b' => '100', 'c' => '70', 'd' => '7010', 'e' => '%NC%', 'f' => 'YYYY-MM-DD']);
        ProductBestSeller::truncate();
        foreach($datas as $data) {
            ProductBestSeller::create([
                'sku' => $data->prd_id,
                'name' => $data->prd_nm,
            ]);
        }
        Log::info('Cronjob berhasil dijalankan');
        return 0;
    }
}