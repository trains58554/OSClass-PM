<?php
$conn = getConnection();
$newPMdrafts = $conn->osc_dbFetchResults("SELECT * FROM %st_pm_drafts WHERE sender_id  = '%d' ORDER BY pm_id DESC", DB_TABLE_PREFIX, osc_logged_user_id());
$countPMdrafts = count($newPMdrafts);
?>
<div class="content user_account">
    <h1>
        <strong><?php echo __('Drafts', 'osclass_pm') . ' (' . $countPMdrafts . ')'; ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
    </div>
</div>