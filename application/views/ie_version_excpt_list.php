<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="index.php?/excpt/ie_version_excpt_list/" method="post">
	<div class="searchBar">

		<table class="searchContent">
			<tr>
                <td>
                    时间：<input name="startDate" type="text" class="date" readonly="true" value="<?php echo $startDate;?>"/> 到 <input name="endDate" type="text" class="date" readonly="true" value="<?php echo $endDate;?>" />
                </td>
			</tr>
            <tr>
                <td>
                    <select class="combox" name="iev">
                        <option value="">IE版本ALL</option>
                        <?php foreach($ievMap as $iev):?>
                            <option value="<?php echo str_replace(' ', '，', str_replace('.', '。', $iev['value']));?>" <?php if($iev['value'] == $search['iev']):?>selected="selected"<?php endif;?>>IE版本<?php echo $iev['value'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="osv">
                        <option value="">操作系统版本ALL</option>
                        <?php foreach($osvMap as $osv):?>
                            <option value="<?php echo str_replace(' ', '，', str_replace('.', '。', $osv['value']));?>" <?php if($osv['value'] == $search['osv']):?>selected="selected"<?php endif;?>>操作系统版本<?php echo $osv['value'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="fv">
                        <option value="">flash版本ALL</option>
                        <?php foreach($fvMap as $fv):?>
                            <option value="<?php echo str_replace(' ', '，', str_replace('.', '。', $fv['value']));?>" <?php if($fv['value'] == $search['fv']):?>selected="selected"<?php endif;?>>flash版本<?php echo $fv['value'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="appv">
                        <option value="">崩溃主程序版本ALL</option>
                        <?php foreach($appvMap as $appv):?>
                            <option value="<?php echo str_replace(' ', '，', str_replace('.', '。', $appv['value']));?>" <?php if($appv['value'] == $search['appv']):?>selected="selected"<?php endif;?>>崩溃主程序版本<?php echo $appv['value'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="os64">
                        <option value="">是否64系统ALL</option>
                        <option value="1" <?php if($search['os64'] === '1'):?>selected="selected"<?php endif;?>>64系统</option>
                        <option value="0" <?php if($search['os64'] === '0'):?>selected="selected"<?php endif;?>>非64系统</option>
                    </select>
                    <select class="combox" name="procType">
                        <option value="">进程类型ALL</option>
                        <?php foreach($procTypeMap as $procType):?>
                            <option value="<?php echo $procType['value'];?>" <?php if($procType['value'] == $search['procType']):?>selected="selected"<?php endif;?>><?php echo $procType['description'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="browserMode">
                        <option value="">进程模型ALL</option>
                        <?php foreach($browserModeMap as $browserMode):?>
                            <option value="<?php echo $browserMode['value'];?>" <?php if($browserMode['value'] == $search['browserMode']):?>selected="selected"<?php endif;?>><?php echo $browserMode['description'];?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="combox" name="bExit">
                        <option value="">进程是否退出ALL</option>
                        <option value="1" <?php if($search['bExit'] === '1'):?>selected="selected"<?php endif;?>>进程已退出</option>
                        <option value="0" <?php if($search['bExit'] === '0'):?>selected="selected"<?php endif;?>>进程没退出</option>
                    </select>
                    <select class="combox" name="threadStatus">
                        <option value="">线程状态ALL</option>
                        <?php foreach($threadStatusMap as $threadStatus):?>
                            <option value="<?php echo $threadStatus['value'];?>" <?php if($threadStatus['value'] == $search['threadStatus']):?>selected="selected"<?php endif;?>><?php echo $threadStatus['description'];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    崩溃进程ID：<input type="text" class="textInput" name="excptpid" value="<?php echo $search['excptpid'];?>"/>
                    崩溃线程ID：<input type="text" class="textInput" name="excpttid" value="<?php echo $search['excpttid'];?>"/>
                    崩溃页面URL：<input type="text" class="textInput" name="excptUrl" value="<?php echo $search['excptUrl'];?>"/>
                    进程异常次数：<input type="text" class="textInput" name="excptCnt" value="<?php echo $search['excptCnt'];?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    崩溃时间：<input type="text" class="textInput" name="excptTm" value="<?php echo $search['excptTm'];?>"/>
                    进程开启时长：<input type="text" class="textInput" name="tckExcpt" value="<?php echo $search['tckExcpt'];?>"/>
                    线程中异常代码：<input type="text" class="textInput" name="threadErr" value="<?php echo $search['threadErr'];?>"/>
                    崩溃进程启动参数：<input type="text" class="textInput" name="appcdln" value="<?php echo $search['appcdln'];?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    崩溃发生模块：<input type="text" class="textInput" name="excptmod" value="<?php echo $search['excptmod'];?>"/>
                    崩溃模块版本：<input type="text" class="textInput" name="excptmodv" value="<?php echo $search['excptmodv'];?>"/>
                    崩溃代码：<input type="text" class="textInput" name="excptcode" value="<?php echo $search['excptcode'];?>"/>
                    崩溃地址（偏移）：<input type="text" class="textInput" name="excptaddr" value="<?php echo $search['excptaddr'];?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    崩溃堆栈：<input type="text" class="textInput" name="excptwalk" value="<?php echo $search['excptwalk'];?>"/>
                    崩溃堆栈MD5：<input type="text" class="textInput" name="excptMD5" value="<?php echo $search['excptMD5'];?>"/>
                    uuid：<input type="text" class="textInput" name="uuid" value="<?php echo $search['uuid'];?>"/>
                </td>
            </tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">

	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th>IE版本</th>
				<th>崩溃次数</th>
				<th>崩溃占比</th>
				<th>下载dump</th>
			</tr>
		</thead>
		<tbody>

        <?php foreach($ieVersionExcptList as $ieVersionExcpt):?>
			<tr target="sid_user" rel="1">
				<td><?php echo $ieVersionExcpt['iev'];?></td>
				<td><?php echo $ieVersionExcpt['ieVersionExcpt'];?></td>
				<td><?php echo $ieVersionExcpt['ieVersionExcptProportion'] . '%';?></td>
				<td><a href="index.php?/excpt/dump_list/<?php echo $ieVersionExcpt['iev'];?>/<?php echo $searchStr;?>" target="navTab" rel="<?php echo $ieVersionExcpt['iev'];?>" fresh="true">下载</a></td>
			</tr>
        <?php endforeach;?>

		</tbody>
	</table>
</div>
