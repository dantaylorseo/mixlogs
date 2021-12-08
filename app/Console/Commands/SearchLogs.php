<?php

namespace App\Console\Commands;

use App\Models\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SearchLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'searchlogs';

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

        $searchArray = [
            "nvaackowdl5uc4dv4meckwiie",
            "nvaacknwdl5nr4uquw3ardy4q",
            "nvaackmgdl5g53dedxjdotc66",
            "nvaackowdl5amkuuqzeifvpxm",
            "nvaackogdl47vwumgp6tnntlu",
            "nvaackowdl5gb3da2iy3l7wmy",
            "nvaackmgdl5gw3cvgkjhzbcow",
            "nvaackngdl5l6u2bgqkvtrxya",
            "nvaackmwdl5hodhzb4x3vu632",
            "nvaackowdl5qch2ntd24sugqc",
            "nvaackogdl5suucnrbyzwtpcg",
            "nvaackogdl5gwxgey4cnpqab2",
            "nvaackngdl5np45vvuxym2xic",
            "nvaacknwdl46x7qejs3seaw7i",
            "nvaackowdl5j2hlysboxgtpno",
            "nvaackogdl5edo72axmh72cws",
            "nvaackngdl5enaigugvyuuss2",
            "nvaackpgdl5utadrl3rnonvk4",
            "nvaacknwdl5gryeeblazrlmlu",
            "nvaackmgdl44wokaccmm5pfag",
            "nvaackpgdl5iodg3cfchnjyzw",
            "nvaackngdl5qjvegwvngdgcpm",
            "nvaackogdl5vfuis4t7arxcxo",
            "nvaackowdl5j3hl2qrzn5dvpo",
            "nvaackogdl5ra76qebvuovchu",
            "nvaacknwdl442plf4zv7lhc7a",
            "nvaackpgdl5e7w6q3jgb42hmy",
            "nvaackngdl5prrcnu7udswjlm",
            "nvaacknwdl5dp34syoidcy4fi",
            "nvaacklwdl5qip6aiqovugjrq",
            "nvaackpgdl5gohb7kjnwkhnww",
            "nvaacklwdl5gixgltegeowd2u",
            "nvaackmwdl5le3qx2kjachidm",
            "nvaackmwdl5a2sxjfm7pby55m",
            "nvaackowdl5hjpf4fltjxfkws",
            "nvaackowdl44z2l4miksb3kyc",
            "nvaacklwdl5q7h7tfjvuuv36w",
            "nvaacknwdl5nbmtihsy7jqe5y",
            "nvaackowdl4362j2zdu3fv6si",
            "nvaackmgdl5jgdiltpzk6v4n6",
            "nvaacknwdl5bfhwira4cj55qc",
            "nvaacknwdl42dxem6vbredddy",
            "nvaackmgdl5f5da2hzvtfxc5k",
            "nvaackngdl5uhvnmw3wscvfbw",
            "nvaackpgdl5kihlhowgmem5ty",
            "nvaackpgdl5dns2wrgi7pbes2",
            "nvaackowdl5rh75fx3giesyhm",
            "nvaacklwdl45xwrauamp6m526",
            "nvaacknwdl5nhytzmzgvxsleg",
            "nvaackmwdl5ltlr25xdzsnz6c",
            "nvaacklwdl5rkuaqbfx7ddkwe",
            "nvaackogdl44e6ln4df4xkf24",
            "nvaacknwdl443lljfqvqdhloq",
            "nvaackowdl5ky3n76wgeezgba",
            "nvaacklwdl5lfpsjd5f4mbicg",
            "nvaackmwdl5gxtgdnahjj3tqq",
            "nvaackmwdl5lm3rlfhsq5km32",
            "nvaackogdl5nkdvxiqcwahhkw",
            "nvaackpgdl5tyybrmrw6qsv3s",
            "nvaackmwdl5diw5tghd4in3kw",
            "nvaacknwdl44exjquxya4aj6c",
            "nvaackogdl5dvs6wfkm4yths4",
            "nvaackmgdl5efs4w2eazsq4c6",
            "nvaackngdl4z3lnwsciotp5fg",
            "nvaacknwdl5d7x57hk6ukr65s",
            "nvaackngdl5j4qvga5mfkp4ko",
            "nvaackngdl44j7tvfxbw7tisq",
            "nvaackmgdl5ted7ua644vlc46",
            "nvaacknwdl47vdso3fxwj2c2g",
            "nvaackogdl5cag2dzjxb4ffbs",
            "nvaackngdl47lp3gc3vvwmkuy",
            "nvaacklwdl5jtlonr4yigocli",
            "nvaacklwdl45qsqofv3gvdfkc",
            "nvaackpgdl5gclbclwu6w7e26",
            "nvaackogdl5ordyutaqfpvyw2",
            "nvaacklwdl4z2kg7vytmhnrq6",
            "nvaackmwdl5jzpnrktniwlsjk",
            "nvaackngdl5ju4uvwomwddafe",
            "nvaacknwdl45wpnqlleeqcifi",
            "nvaacknwdl5lyaqkjutttr5xw",
            "nvaackogdl5veeip2oy6op5c6",
            "nvaackowdl5fqxbtz57p26tjy",
            "nvaacknwdl47npr4k6lk53dtw",
            "nvaackpgdl43msgwjsqroaglm",
            "nvaackpgdl5epg5hjyn2phbmy",
            "nvaacklwdl423kjrftcwkytdo",
            "nvaacklwdl5j2ppaqkrypjd5m",
            "nvaacklwdl5dxladu42wcbsas",
            "nvaackmgdl5f77bamt5uknnsa",
            "nvaackogdl5tleegsz2zytgba",
            "nvaackowdl5eec6ht2cmmqcyc",
            "nvaackngdl5j3yveh7qud2mqa",
            "nvaackpgdl5kddkz7hbyx3cre",
            "nvaackpgdl5lpxoaf6ov6iggi",
            "nvaackmgdl5kkpld3kid2hl32",
            "nvaackmwdl5km7o77l7wjsk4e",
            "nvaacklwdl47owvia3opcbfsg",
            "nvaackmgdl5iq7g4kezfglluc",
            "nvaackmgdl4zm2bxpimgebsai",
            "nvaackmgdl44goizlivaahkia",
            "nvaackowdl5fe7awg66shnbgw",
            "nvaacknwdl4257gp5zexsilty",
            "nvaackpgdl457wnbmlm2e6bqs",
            "nvaackowdl5mh3roj3nasoqty",
            "nvaackmwdl5medtdwphpay35s",
            "nvaackowdl42bwfc2bruwweti",
            "nvaackogdl5ab6vkwja5dtkiu",
            "nvaackogdl44jclyftakiqqdi",
            "nvaackmwdl5jjpmixtykyoxdq",
            "nvaackogdl5bykzrijnhkolkq",
            "nvaackpgdl5r6x5jd7ot7gryw",
            "nvaackmwdl44q6mcqcnl7bxhw",
            "nvaackngdl5gyenxmjyxj67e6",
            "nvaackpgdl5mg3pu357wqcebi",
            "nvaackogdl5khlojj7as5f2io",
            "nvaackmwdl5ub4fvqyu4nvkog",
            "nvaackpgdl5viyfexeo2jljzq",
            "nvaackngdl5h5iqo25zkftbng",
            "nvaackpgdl47wwriht6yjrwsg",
            "nvaackogdl5t7yfwx24qc4kig",
            "nvaackngdl5iyyss7czatkgho",
            "nvaackngdl5oofaafruezubpm",
            "nvaackowdl453sorubrxrvt4e",
            "nvaackpgdl5bksvhgkad2xuru",
            "nvaacklwdl5h7xksvcq2dscme",
            "nvaackpgdl44mojffb2qw3h7w",
            "nvaackngdl44zxu2bk53umxgc",
            "nvaackogdl5aagvhoaddldds6",
            "nvaackowdl5kg7mux3xpybonw",
            "nvaackowdl45e2mzidgsqzm2g",
            "nvaackogdl472cuxjhotxuq6m",
            "nvaackmgdl5tlaaearhuiwlbu",
            "nvaackngdl44kxtwkh6iki6zm",
            "nvaackogdl5ls3rwtd7ygkduu",
            "nvaackngdl5rhzgm2bjxykoni",
            "nvaacknwdl5kwuobfxnzyc5i6",
            "nvaackngdl5olm7zfjrrqdebq",
            "nvaacklwdl44xcojvzmqpu75y",
            "nvaacknwdl5f2qcp3bbwjswdw",
            "nvaacknwdl5t3jdue5t4e32jq",
            "nvaackpgdl5oolu47rmo6ffv2",
            "nvaacknwdl5k5iopskymuqcsq",
            "nvaackogdl477ovfg7tooekn4",
            "nvaackowdl5ih3icqjtj43756",
            "nvaackmgdl5kepku7axosk7qu",
            "nvaackowdl5m2hsz6efdm24c6",
            "nvaacklwdl46xwtpfclfwmm56",
            "nvaacknwdl5i54jxz4lkjpgoe",
            "nvaackmwdl5umignac4yplt7a",
            "nvaackmwdl5hfxhez5xjntseg",
            "nvaackowdl5q574qxntr4sqn2",
            "nvaackmgdl46a6nhvfjgs4j5u",
            "nvaackpgdl5q4d2zilzitn3zu",
            "nvaackpgdl5fow7snx3wtonic",
            "nvaackmwdl5gkxfgdpx4ddc4u",
            "nvaacklwdl5mb7uh34445u3jo",
            "nvaackmwdl5d2o7bnu437jv6u",
            "nvaacklwdl5fwpe7rpprcq6m2",
            "nvaackpgdl5dq2262ii3otzcs",
            "nvaackowdl5a66v72gjen42du",
            "nvaackmgdl4646pmh7pwud2q4",
            "nvaacknwdl5gamc4clwacz7dw",
            "nvaackmgdl5g73djoy4e2nj6q",
            "nvaackmgdl5iq7g4kezfglluc",
            "nvaackmgdl45w2mqgslo6lico",
            "nvaackmgdl42bsdhtfkv6kasq",
            "nvaackogdl44w2m2wpn2hfvs2",
            "nvaackowdl4zm6dpr5jlzruyk",
            "nvaackogdl46z6seazchyffmo",
            "nvaackpgdl5jhtiywhta6ngbo",
            "nvaacknwdl5nauthafenrpkeo",
            "nvaackmgdl5k4xmpbjny7gkea",
            "nvaackmgdl4372ihj7wutml2g",
            "nvaackogdl44rwmo2uq23krle",
            "nvaackmwdl446wnfpmvdpv7nc",
            "nvaacknwdl4z57d7dufxtmepe",
            "nvaackmgdl474krwh6xkz6n4y",
            "nvaackngdl5fwyllswsdgd7rg",
            "nvaacknwdl5ucjees222rag76",
            "nvaackpgdl5vdeew743zpjxjg",
            "nvaackowdl5uc4dv4meckwiie",
            "nvaackmwdl5qyp6cqpyqtxuq6",
            "nvaackmwdl44v6mn2z3bmwmzu",
            "nvaackowdl5smh7voy45pv63s",
            "nvaackmwdl5ic3jkpkndziums",
            "nvaackpgdl5b3cwov42tljvyy",
            "nvaackogdl5oh3x4ukjoihggw",
            "nvaackpgdl44sgjsvwyoe57ds",
            "nvaackowdl42bkfb65cexmths",
            "nvaacklwdl5tbeepop6xmkxyw",
            "nvaackmwdl44nwlz4cgt3ahny",
            "nvaackowdl42pcgdb4pksxims",
            "nvaackogdl4z7wf4fdwrqjxy4"
        ];

        $countArray4 = [
            'nvaacklwdl5lfpsjd5f4mbicg', 'nvaackmwdl5gxtgdnahjj3tqq', 'nvaackmwdl5lm3rlfhsq5km32',
            'nvaackogdl5nkdvxiqcwahhkw', 'nvaackpgdl5tyybrmrw6qsv3s', 'nvaackmwdl5diw5tghd4in3kw',
            'nvaacknwdl44exjquxya4aj6c', 'nvaackogdl5dvs6wfkm4yths4', 'nvaackmgdl5efs4w2eazsq4c6',
            'nvaackngdl4z3lnwsciotp5fg', 'nvaacknwdl5d7x57hk6ukr65s', 'nvaackngdl5j4qvga5mfkp4ko',
            'nvaackngdl44j7tvfxbw7tisq', 'nvaackmgdl5ted7ua644vlc46', 'nvaacknwdl47vdso3fxwj2c2g',
            'nvaackogdl5cag2dzjxb4ffbs', 'nvaackngdl47lp3gc3vvwmkuy', 'nvaacklwdl5jtlonr4yigocli',
            'nvaacklwdl45qsqofv3gvdfkc', 'nvaackpgdl5gclbclwu6w7e26', 'nvaackogdl5ordyutaqfpvyw2',
            'nvaacklwdl4z2kg7vytmhnrq6', 'nvaackmwdl5jzpnrktniwlsjk', 'nvaackngdl5ju4uvwomwddafe',
            'nvaacknwdl45wpnqlleeqcifi', 'nvaacknwdl5lyaqkjutttr5xw', 'nvaackogdl5veeip2oy6op5c6',
            'nvaackowdl5fqxbtz57p26tjy', 'nvaacknwdl47npr4k6lk53dtw', 'nvaackpgdl43msgwjsqroaglm',
            'nvaackpgdl5epg5hjyn2phbmy', 'nvaacklwdl423kjrftcwkytdo', 'nvaacklwdl5j2ppaqkrypjd5m',
            'nvaacklwdl5dxladu42wcbsas', 'nvaackmgdl5f77bamt5uknnsa', 'nvaackogdl5tleegsz2zytgba',
            'nvaackowdl5eec6ht2cmmqcyc', 'nvaackngdl5j3yveh7qud2mqa', 'nvaackpgdl5kddkz7hbyx3cre',
            'nvaackpgdl5lpxoaf6ov6iggi', 'nvaackmgdl5kkpld3kid2hl32', 'nvaackmwdl5km7o77l7wjsk4e',
            'nvaacklwdl47owvia3opcbfsg', 'nvaackmgdl5iq7g4kezfglluc', 'nvaackmgdl4zm2bxpimgebsai',
            'nvaackmgdl44goizlivaahkia', 'nvaackowdl5fe7awg66shnbgw', 'nvaacknwdl4257gp5zexsilty',
            'nvaackpgdl457wnbmlm2e6bqs', 'nvaackowdl5mh3roj3nasoqty', 'nvaackmwdl5medtdwphpay35s',
            'nvaackowdl42bwfc2bruwweti', 'nvaackogdl5ab6vkwja5dtkiu', 'nvaackogdl44jclyftakiqqdi',
            'nvaackmwdl5jjpmixtykyoxdq'
        ];

        $countArray5 =  [
            'nvaackogdl5bykzrijnhkolkq', 'nvaackpgdl5r6x5jd7ot7gryw', 'nvaackmwdl44q6mcqcnl7bxhw',
            'nvaackngdl5gyenxmjyxj67e6', 'nvaackpgdl5mg3pu357wqcebi', 'nvaackogdl5khlojj7as5f2io',
            'nvaackmwdl5ub4fvqyu4nvkog', 'nvaackpgdl5viyfexeo2jljzq', 'nvaackngdl5h5iqo25zkftbng',
            'nvaackpgdl47wwriht6yjrwsg', 'nvaackogdl5t7yfwx24qc4kig', 'nvaackngdl5iyyss7czatkgho',
            'nvaackngdl5oofaafruezubpm', 'nvaackowdl453sorubrxrvt4e', 'nvaackpgdl5bksvhgkad2xuru',
            'nvaacklwdl5h7xksvcq2dscme', 'nvaackpgdl44mojffb2qw3h7w', 'nvaackngdl44zxu2bk53umxgc',
            'nvaackogdl5aagvhoaddldds6', 'nvaackowdl5kg7mux3xpybonw', 'nvaackowdl45e2mzidgsqzm2g',
            'nvaackogdl472cuxjhotxuq6m', 'nvaackmgdl5tlaaearhuiwlbu', 'nvaackngdl44kxtwkh6iki6zm',
            'nvaackogdl5ls3rwtd7ygkduu', 'nvaackngdl5rhzgm2bjxykoni', 'nvaacknwdl5kwuobfxnzyc5i6',
            'nvaackngdl5olm7zfjrrqdebq', 'nvaacklwdl44xcojvzmqpu75y', 'nvaacknwdl5f2qcp3bbwjswdw',
            'nvaacknwdl5t3jdue5t4e32jq', 'nvaackpgdl5oolu47rmo6ffv2', 'nvaacknwdl5k5iopskymuqcsq',
            'nvaackogdl477ovfg7tooekn4', 'nvaackowdl5ih3icqjtj43756', 'nvaackmgdl5kepku7axosk7qu',
            'nvaackowdl5m2hsz6efdm24c6', 'nvaacklwdl46xwtpfclfwmm56', 'nvaacknwdl5i54jxz4lkjpgoe',
            'nvaackmwdl5umignac4yplt7a', 'nvaackmwdl5hfxhez5xjntseg', 'nvaackowdl5q574qxntr4sqn2',
            'nvaackmgdl46a6nhvfjgs4j5u', 'nvaackpgdl5q4d2zilzitn3zu', 'nvaackpgdl5fow7snx3wtonic',
            'nvaackmwdl5gkxfgdpx4ddc4u', 'nvaacklwdl5mb7uh34445u3jo', 'nvaackmwdl5d2o7bnu437jv6u',
            'nvaacklwdl5fwpe7rpprcq6m2', 'nvaackpgdl5dq2262ii3otzcs', 'nvaackowdl5a66v72gjen42du',
            'nvaackmgdl4646pmh7pwud2q4', 'nvaacknwdl5gamc4clwacz7dw', 'nvaackmgdl5g73djoy4e2nj6q',
            'nvaackmgdl5iq7g4kezfglluc', 'nvaackmgdl45w2mqgslo6lico', 'nvaackmgdl42bsdhtfkv6kasq',
            'nvaackogdl44w2m2wpn2hfvs2', 'nvaackowdl4zm6dpr5jlzruyk', 'nvaackogdl46z6seazchyffmo',
            'nvaackpgdl5jhtiywhta6ngbo', 'nvaacknwdl5nauthafenrpkeo', 'nvaackmgdl5k4xmpbjny7gkea',
            'nvaackmgdl4372ihj7wutml2g', 'nvaackogdl44rwmo2uq23krle', 'nvaackmwdl446wnfpmvdpv7nc',
            'nvaacknwdl4z57d7dufxtmepe', 'nvaackmgdl474krwh6xkz6n4y', 'nvaackngdl5fwyllswsdgd7rg',
            'nvaacknwdl5ucjees222rag76', 'nvaackpgdl5vdeew743zpjxjg'
        ];

        $countArray6 =  [
            'nvaackowdl5uc4dv4meckwiie',
            'nvaackmwdl5qyp6cqpyqtxuq6',
            'nvaackmwdl44v6mn2z3bmwmzu',
            'nvaackowdl5smh7voy45pv63s',
            'nvaackmwdl5ic3jkpkndziums',
            'nvaackpgdl5b3cwov42tljvyy',
            'nvaackogdl5oh3x4ukjoihggw',
            'nvaackpgdl44sgjsvwyoe57ds',
            'nvaackowdl42bkfb65cexmths',
            'nvaacklwdl5tbeepop6xmkxyw',
            'nvaackmwdl44nwlz4cgt3ahny',
            'nvaackowdl42pcgdb4pksxims',
            'nvaackogdl4z7wf4fdwrqjxy4'
        ];

        // $total = count( $searchArray );
        // $found = 0;
        // foreach( $searchArray as $id ) {
        //     if( !empty( Session::where('sessionid', $id)->first() ) ) {
        //         $this->info("✅ $id Found");
        //         $found += 1;
        //     } else {
        //         $this->info("❌ $id Not Found");
        //     }
        // }
        // $percent = number_format(($found/$total) * 100, 0);
        // $this->info("Found $found/$total ($percent%)");


        $sessions = Session::whereIn('sessionid', $countArray6)->whereHas('logs', function($query) {
            $query
                  ->where("events", "LIKE", '%Read timed out%')
                  //->where('data', "LIKE", "%cp64_HelpAPIFail_MS%")
                  ;
        })->get();

        // $sessions = Session::whereIn('sessionid', $countArray4)->whereHas('logs', function($query) {
        //     $query
        //           ->where("data", "LIKE", '%maxnoinputs%')
        //           //->orWhere('events', "LIKE", "%cp64_HelpAPIFail_MS%")
        //           ;
        // })->get();

        $this->info( count( $countArray6) );
        $this->info( $sessions->count() );
        $csv = [];
        foreach( $sessions as $session ) {
            // $maxcontext = 0;
            // foreach( $session->logs() as $log ) {

            // }
             $this->info( "http://127.0.0.1:8000/log/".$session->sessionid );
            $foundMax[] = $session->sessionid;
            $csv[] = Str::replace('nvaa', '', $session->sessionid);
        }
        dump(array_diff($countArray6, $foundMax));
        //dump( $csv);

        // dump("Max:" . $foundMax);

        // $sessions = Session::whereIn('sessionid', $countArray4)->whereHas('logs', function($query) {
        //     $query
        //           ->where("data", "LIKE", '%maxnoinputs%')
        //           //->orWhere('events', "LIKE", "%cp64_HelpAPIFail_MS%")
        //           ;
        // })->get();

        // $this->info( count( $countArray4) );
        // $this->info( $sessions->count() );

        // foreach( $sessions as $session ) {
        //     // $maxcontext = 0;
        //     // foreach( $session->logs() as $log ) {

        //     // }
        //     // $this->info( "http://127.0.0.1:8000/log/".$session->sessionid.'::: Max Context size:'. $maxcontext );
        //     $foundMax[] = $session->sessionid;
        // }

        // dump($foundMax);

        // //dump(array_diff($countArray4, $found));

        // $sessions = Session::whereIn('sessionid', $countArray5)->whereHas('logs', function($query) {
        //     $query
        //           //->whereJsonContains("events->value->to->name", "=", '07_WISMO_APIFail_MS')
        //           ->whereJsonContains('events', [ 'value' => [ 'to' => [ 'name' => "07_WISMO_APIFail_MS" ] ] ] )
        //           ->whereJsonContains('events', [ 'value' => [ 'from' => [ 'name' => "88_WhichParcelStatus_AfterEDD_DS" ] ] ] )
        //           ;
        // })->get();

        // foreach( $sessions as $session ) {
        //     // $maxcontext = 0;
        //     // foreach( $session->logs() as $log ) {

        //     // }
        //     // $this->info( "http://127.0.0.1:8000/log/".$session->sessionid.'::: Max Context size:'. $maxcontext );
        //     $found5[] = $session->sessionid;
        // }

        // //dump($found5);

        // dump(array_diff($countArray5, $found5));

        // $this->info( count( $countArray5) );
        // $this->info( $sessions->count() );

        return Command::SUCCESS;

    }
}



























































