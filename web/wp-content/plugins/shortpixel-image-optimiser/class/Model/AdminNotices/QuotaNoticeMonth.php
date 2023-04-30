<?php
namespace ShortPixel\Model\AdminNotices;
use ShortPixel\Controller\StatsController as StatsController;
use ShortPixel\Controller\AdminNoticesController as AdminNoticesController;
use ShortPixel\Controller\QuotaController as QuotaController;

class QuotaNoticeMonth extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_UPGRADE_MONTH';

	public function load()
	{
		 $this->callback = array(AdminNoticesController::getInstance(), 'proposeUpgradePopup');
		 parent::load();
	}

	protected function checkTrigger()
	{
			$quotaController = QuotaController::getInstance();

			if ($quotaController->hasQuota() === false)
				return false;

			$quotaData = $quotaController->getQuota();

			if ($this->monthlyUpgradeNeeded($quotaData) === false)
				return false;

			$this->addData('average', $this->getMonthAverage());
			$this->addData('month_total', $quotaData->monthly->total);
			$this->addData('onetime_remaining', $quotaData->onetime->remaining);

	}

	protected function getMessage()
	{
		$quotaController = QuotaController::getInstance();

		$quotaData = $quotaController->getQuota();
		$average = $this->getMonthAverage(); // $this->getData('average');
		$month_total = $quotaData->monthly->total;// $this->getData('month_total');
		$onetime_remaining = $quotaData->onetime->remaining; //$this->getData('onetime_remaining'); */

		$message = '<p>' . sprintf(__("You add an average of <strong>%d images and thumbnails</strong> to your Media Library every month and you have <strong>a plan of %d images/month (and %d one-time images)</strong>.%s"
					. " You may need to upgrade your plan to have all your images optimized.", 'shortpixel-image-optimiser'), $average, $month_total, $onetime_remaining, '<br>') . '</p>';

		$message .= '  <button class="button button-primary" id="shortpixel-upgrade-advice" onclick="ShortPixel.proposeUpgrade()" style="margin-right:10px;"><strong>' .  __('Show me the best available options', 'shortpixel-image-optimiser') . '</strong></button>';

		return $message;
	}

	protected function CheckUpgradeNeeded($quotaData)
	{
			if  (isset($quotaData->monthly->total) && !$quotaData->unlimited)
			{
					$monthAvg = $this->getMonthAvg($quotaData);
					// +20 I suspect to not trigger on very low values of monthly use(?)
					$threshold = $quotaData->monthly->total + ($quotaData->onetime->remaining / 6 ) +20;

					if ($monthAvg > $threshold)
					{
							return true;
					}
			}
			return false;
	}

	protected function getMonthAverage() {
			$stats = StatsController::getInstance();

			// Count how many months have some optimized images.
			for($i = 4, $count = 0; $i>=1; $i--) {
					if($count == 0 && $stats->find('period', 'months', $i) == 0)
					{
						continue;
					}
					$count++;

			}
			// Sum last 4 months, and divide by number of active months to get number of avg per active month.
			return ($stats->find('period', 'months', 1) + $stats->find('period', 'months', 2) + $stats->find('period', 'months', 3) + $stats->find('period', 'months', 4) / max(1,$count));
	}

	protected function monthlyUpgradeNeeded($quotaData)
	{
			if  (isset($quotaData->monthly->total))
			{
					$monthAvg = $this->getMonthAverage($quotaData);
					// +20 I suspect to not trigger on very low values of monthly use(?)
					$threshold = $quotaData->monthly->total + ($quotaData->onetime->remaining / 6 ) +20;

					if ($monthAvg > $threshold)
					{
							return true;
					}
			}
			return false;
	}
} // class
