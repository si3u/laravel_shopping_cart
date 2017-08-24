<?php
namespace App\Views\Composers;
use App\Order;
use App\ProductComment;
use App\ProductReview;
use Illuminate\View\View;

class NotificationComposer {
    protected $new_comments;
    protected $new_reviews;
    protected $new_orders;

    public function __construct() {
        $this->new_comments = ProductComment::where('read_status', false)->count();
        $this->new_reviews = ProductReview::where('read_status', false)->count();
        $this->new_orders = Order::where('read_status', false)->count();
    }

    public function compose(View $view) {
        $view->with([
            'count_new_comments' => $this->new_comments,
            'count_new_reviews' => $this->new_reviews,
            'all_notifications_catalog' => $this->new_comments+$this->new_reviews,
            'count_new_orders' => $this->new_orders,
            'count_notifications' => $this->new_reviews+$this->new_comments+$this->new_orders,
        ]);
    }
}