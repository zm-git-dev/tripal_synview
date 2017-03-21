<?php

print '<div class="row"> <div class="col-md-8 col-md-offset-2">';

$org_id  = $_SESSION['tripal_synview_search']['SELECT_GENOME'];
$chr_id  = $_SESSION['tripal_synview_search']['SELECT_CHR'];
$chr     = $_SESSION['tripal_synview_search']['REF'][$org_id][$chr_id];
$start   = $_SESSION['tripal_synview_search']['START'];
$end     = $_SESSION['tripal_synview_search']['END'];
$reference = "$chr : $start  -  $end";

$ac_left  = l("<<<", "synview/search/result/left");
$ac_right = l(">>>", "synview/search/result/right");
print '<button type="button" class="btn btn-default"> ' . $ac_left . '</button>';
print "  $reference  ";
print '<button type="button" class="btn btn-default"> ' . $ac_right. '</button>';


if (count($blocks) == 0) {
  ?><p>no block is found!</p><?php
} 
else {

  $rows = array();
  $headers = array('Block' , 'Organism1 (location)', 'Organism2 (location)', 'score', 'evalue');

  $n = 0;
  $color = '#DEEEEE';

  foreach ($cluster as $cls) {
    $n++;
    foreach ($cls as $bid) {
      $b = $blocks[$bid];
      $block_id = $b->blockid;
      $block_id = l($block_id, "synview/block/". $block_id, array('attributes' => array('target' => "_blank")));
      $organism1 = $b->b1_org . "<br>" . $b->b1_sid . " : ". $b->b1_fmin . " - ".$b->b1_fmax;
      $organism2 = $b->b2_org . "<br>" . $b->b2_sid . " : ". $b->b2_fmin . " - ".$b->b2_fmax;
 
      if ($n % 2 == 1) {
        $rows[] = array(
          array('data'=> $block_id,  'width' => '10%', 'bgcolor' => $color),
          array('data'=> $organism1, 'width' => '20%', 'bgcolor' => $color),
          array('data'=> $organism2, 'width' => '20%', 'bgcolor' => $color),
          array('data'=> $b->score,  'width' => '10%', 'bgcolor' => $color),
          array('data'=> $b->evalue, 'width' => '10%', 'bgcolor' => $color),
        );
      } else {
        $rows[] = array(  
          array('data'=> $block_id, 'width' => '10%'),
          array('data'=> $organism1, 'width' => '20%'),
          array('data'=> $organism2, 'width' => '20%'),
          array('data'=> $b->score, 'width' => '10%'),
          array('data'=> $b->evalue, 'width' => '10%'),
        );
      }
    }
  }

  $table = array(
    'header' => $headers,
    'rows' => $rows,
    'attributes' => array(
      'id' => 'tripal_synview-search-result',
      'class' => 'tripal-data-table table'
    ),
    'sticky' => FALSE,
    'caption' => '',
    'colgroups' => array(),
    'empty' => '',
  );

  print theme_table($table);

}

print '</div></div>';

?>


