<?php $this->load_fragment('skeleton_template/header', ['title' => __('Schedule')]); ?>
<article class="page schedule">
<header>
          <h1>Sche<span class="tabheading">dule</span></h1>
</header>
<?php
    $events_list = array_filter($events_data, function ($event) {
        return $event['template'] == 'event';
    });
    usort($events_list, function($a, $b) {
        if (!isset($b['data']['start_time'])) {
            return -1;
        }
        else if (!isset($a['data']['start_time'])) {
            return 1;
        }
        $a_date = $a['data']['start_time'];
        $b_date = $b['data']['start_time'];
        $a_enddate = $a['data']['end_time'];
        $b_enddate = $b['data']['end_time'];
        $now=@date('Y-m-d H:i');
        if ($a_enddate >= $now xor $b_enddate >= $now) {
            if ($a_enddate >= $now) {
                return -1;
            }
            else {
                return 1;
            }
        }
        if ($a_date == $b_date) {
            return 0;
        }
        return ($a_date < $b_date) ? -1 : 1;
    });

    $dates = array();
    foreach ($events_list as &$evref) {
        $evref['path'] = substr($evref['path'], 1);
        $evref['type'] = substr($evref['path'], 0, - (strlen($evref['slug']) + 2));
        $cur = date_parse($evref['data']['start_time']);
        array_push($dates, $cur['month']."-".$cur['day']);
    }
    $is_imp = function($date) use ($dates) {
        if ( in_array($date, $dates) ) {
            echo " class='has-event'";
        }
    };
?>

<div class="container row">
    <div class="col6">
        <div class="cal-month">
            <table class="cal-table" data-month="Jan">
                <thead>
                    <tr>
                        <th class="cal-month-name" colspan="7"><?= strftime('%B %Y', strtotime('January 2017')) ?></th>
                    </tr>
                    <tr>
                        <th><?= strftime('%a', strtotime('Sun')) ?></th>
                        <th><?= strftime('%a', strtotime('Mon')) ?></th>
                        <th><?= strftime('%a', strtotime('Tue')) ?></th>
                        <th><?= strftime('%a', strtotime('Wed')) ?></th>
                        <th><?= strftime('%a', strtotime('Thu')) ?></th>
                        <th><?= strftime('%a', strtotime('Fri')) ?></th>
                        <th><?= strftime('%a', strtotime('Sat')) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td<?php $is_imp('1-1'); ?>>1</td>
                        <td<?php $is_imp('1-2'); ?>>2</td>
                        <td<?php $is_imp('1-3'); ?>>3</td>
                        <td<?php $is_imp('1-4'); ?>>4</td>
                        <td<?php $is_imp('1-5'); ?>>5</td>
                        <td<?php $is_imp('1-6'); ?>>6</td>
                        <td<?php $is_imp('1-7'); ?>>7</td>
                    </tr>
                    <tr>
                        <td<?php $is_imp('1-8'); ?>>8</td>
                        <td<?php $is_imp('1-9'); ?>>9</td>
                        <td<?php $is_imp('1-10'); ?>>10</td>
                        <td<?php $is_imp('1-11'); ?>>11</td>
                        <td<?php $is_imp('1-12'); ?>>12</td>
                        <td<?php $is_imp('1-13'); ?>>13</td>
                        <td<?php $is_imp('1-14'); ?>>14</td>
                    </tr>
                    <tr>
                        <td<?php $is_imp('1-15'); ?>>15</td>
                        <td<?php $is_imp('1-16'); ?>>16</td>
                        <td<?php $is_imp('1-17'); ?>>17</td>
                        <td<?php $is_imp('1-18'); ?>>18</td>
                        <td<?php $is_imp('1-19'); ?>>19</td>
                        <td<?php $is_imp('1-20'); ?>>20</td>
                        <td<?php $is_imp('1-21'); ?>>21</td>
                    </tr>
                    <tr>
                        <td<?php $is_imp('1-22'); ?>>22</td>
                        <td<?php $is_imp('1-23'); ?>>23</td>
                        <td<?php $is_imp('1-24'); ?>>24</td>
                        <td<?php $is_imp('1-25'); ?>>25</td>
                        <td<?php $is_imp('1-26'); ?>>26</td>
                        <td<?php $is_imp('1-27'); ?>>27</td>
                        <td<?php $is_imp('1-28'); ?>>28</td>
                    </tr>
                    <tr>
                        <td<?php $is_imp('1-29'); ?>>29</td>
                        <td<?php $is_imp('1-30'); ?>>30</td>
                        <td<?php $is_imp('1-31'); ?>>31</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col6">
        <table class="eventslist">
            <tbody>
                <?php
                    $lastdate = '';
                    foreach ($events_list as $event):
                ?>
                    <tr class="timeline <?= $event['type'] ?>">
                        <?php
                            if ($event['data']['start_time']) {
                                $formatted = strftime('%B %e, %A', date_timestamp_get(date_create($event['data']['start_time'])));
                            } else {
                                $formatted = __("Date to be announced");
                            }
                            if (strcmp($lastdate, $formatted) != 0):
                                $lastdate = $formatted;
                        ?>
                            <td class="day">
                                <?= $formatted ?>
                            </td>
                        <?php else: ?>
                            <td class="day"></td>
                        <?php endif; ?>
                        <td class="event-container">
                            <a href="<?= locale_base_url() . $event['path'] ?>" class="event">
                                <div class="circle"><div class="innercircle"></div></div>
                                <span><?= __($event['data']['name']) ?></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</article>
<?php $this->load_fragment('skeleton_template/footer'); ?>
<?php if (!$is_ajax): ?>
<script>
    (function() {
        $('#toggle').removeClass('i');
        $('.toggle-contact').css('display', 'none');
    })();
</script>
<?php endif; ?>
