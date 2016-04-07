<div class="pageHeader">
</div>
<div class="pageContent">
	<div class="panelBar">

	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th>dump文件名</th>
                <th>崩溃堆栈MD5</th>
                <th>时间</th>
				<th>下载dump</th>
			</tr>
		</thead>
		<tbody>

        <?php foreach($dumpList as $md5 => $dump):?>
        <tr target="sid_user" rel="1">
            <td><?php echo $dump['dump'];?></td>
            <td><?php echo $dump['md5'];?></td>
            <td><?php echo date('Y-m-d H:i:s', $dump['timeStamp']);?></td>
            <td><a href="index.php?/excpt/down_dump/<?php echo base64_encode($dump['path']);?>" target="_blank">下载</a></td>
        </tr>
        <?php endforeach;?>

		</tbody>
	</table>
</div>
