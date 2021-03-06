<?php
$mydata = new ciy_data();
$rsuser = verifyadmin();
$table = 'p_config';
ciy_runJSON();
$msql = new ciy_sql($table);
$rows = $mydata->get($msql);
$rows[] = array('id'=>0);
function json_update() {
    if(nopower('admin'))
        return errjson('您无权操作');
    global $mydata;
    global $table;
    $post = new ciy_post();
    $id = $post->getint('id');
    $updata = array();
    $updata['title'] = $post->get('title');
    $updata['types'] = $post->get('types');
    $updata['params'] = $post->get('params');
    $csql = new ciy_sql($table);
    $csql->where('id',$id);
    $oldrow = $mydata->getone($csql);
    $execute = $mydata->data($updata)->set($csql);
    if ($execute === false)
        return errjson('操作数据库失败.' . $mydata->error);
    savelogdb($table, $oldrow, $updata,"ID={$id}");
    return succjson();
}
function json_del() {
    if(nopower('admin'))
        return errjson('您无权操作');
    global $mydata;
    global $table;
    $post = new ciy_post();
    $csql = new ciy_sql($table);
    $csql->where('id',$post->getint('id'));
    $oldrow = $mydata->getone($csql);
    $execute = $mydata->delete($csql);
    if ($execute === false)
        return errjson('删除数据库失败.' . $mydata->error);
    savelogdb($table, $oldrow, null);
    return succjson();
}
