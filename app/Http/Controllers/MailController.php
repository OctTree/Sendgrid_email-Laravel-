<?php

namespace App\Http\Controllers;
use App\Maillog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\SendMail;
class MailController extends Controller
{
    public $m_log;
    public function __construct()
    {
        $this->m_log = new Maillog();
    }
    public function index(Request $request)
    {
        $current_lists = $this->read($request->user()['email']);
        $rate = [
            $this->rateSent($request->user()['email']),
            $this->rateBounce($request->user()['email']),
            $this->rateDelivered($request->user()['email']),
            $this->rateOpened($request->user()['email'])
        ];
        return view('emails.home')->with('current_lists', $current_lists)->with('rate' , $rate);
    }

    public function sendmail(Request $request)
    {
        $post = array(
            "sender" => $request->user(),
            "receiver" => $request->email_to,
            "subject" => $request->subject,
            "message" => $request->email_content,
            "msg_id" => uniqid() // I have use uniqid() function to get a unique id;
        );

        $cc = $request->email_cc ? $request->email_cc : [];
        $bcc = $request->email_bcc ? $ $request->email_bcc : [];

        $response = Mail::to($post['receiver'])->locale('en')
                             ->cc($cc)
                             ->bcc($bcc)
                             ->send(new SendMail($post));

        $this->store($post, $request->user()['email']);
        $log_lists = $this->read($request->user()['email']);

        return back()->with('success', 'Your message sent succesful!')
                     ->with('log_lists',$log_lists);
    }

    function store($data, $sender){
        $model = $this->m_log;
        $model->s_email = $sender;
        $model->r_email = $data['receiver'];
        $model->subject = $data['subject'];
        $model->message = $data['message'];
        $model->status = 'B';
        $model->msg_id = $data['msg_id'];
        $model->save();
    }

    function read($sender)
    {
        $model = $this->m_log;
        $res = $model::where('s_email', '=', $sender)
                       ->orderBy('id', 'asc')
                       ->get();
        return $res;
    }
    function readA($sender, $opt) {
        $model = $this->m_log;
        $res = $model::where([['s_email', $sender], ['status', $opt]])->get();
        return $res;
    }
    /**
     * here is the function, waiting request from sendgrid api
     *
     * @param Request $request
     * @return void
     */
    public function updateStatus(Request $request) {
       \Log::info('RD: ' . json_encode($request->all()));

        foreach($request->all() as $d) {

            if (isset($d['msg_id']) && $d['event'] === "delivered") {
                // do somethings
                $maillog = Maillog::where('msg_id', $d['msg_id'])->first();
                if($maillog) {
                    $maillog->update(['status' => 'D']);
                   \Log::info('Delivered:' . json_encode($d));
                }
            }
             // we check if we have msg_id and event is open as you see
            else if (isset($d['msg_id']) && $d['event'] === "open") {
                // if use we get the mail from db; and update value;
                $maillog = Maillog::where('msg_id', $d['msg_id'])->first();
                if($maillog) {
                    $maillog->update(['status' => 'O']);
                    \Log::info('Messaage Updated ' . json_encode($d));
                }
            }

            // for example , if you want to check for click event
            else if (isset($d['msg_id']) && $d['event'] === "click") {
                // do somethings
                $maillog = Maillog::where('msg_id', $d['msg_id'])->first();
                if($maillog) {
                    $maillog->update(['status' => 'C']);
                   \Log::info('Clicked:' . json_encode($d));
                }
            }
        }
        // return redirect('mail');
    }

    public function rateSent($user){
        return ['sent'=>count($this->read($user))] ;
    }
    public function rateBounce($user) {
        return ["bounced"=>count($this->readA($user, "B"))];
    }
    public function rateDelivered($user) {
        return ["delivered"=>count($this->readA($user, "D"))];
    }
    public function rateOpened($user) {
        return ["opened"=>count($this->readA($user, "O"))];
    }
}
