public $notification;
public function __construct($notification){ $this->notification=$notification; }
public function broadcastOn(){ return ['notifications']; }
public function broadcastAs(){ return 'notification.new'; }
