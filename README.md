# CentVM PXE / NetBoot Web Server UI | PHP 7.2+
<center><b>CentVM PXE / NetBoot Web Server UI | PHP 7.2+</b></center><br>
<center><b>Supporting CentOS 7+</b></center><br>
<br>
<pre>
Update v1.3 - You must write on commandline at every reboot
setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
chmod -R 777 /var/lib/tftpboot/data
chown -R nobody:nobody /var/lib/tftpboot/data
chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data
semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data
/sbin/restorecon -R -v /var/lib/tftpboot
</pre><br>
<center>
<b>PXE ISO Upload & Download</b></br>
<img src="pics/1.png"><br>
<b>PXE ISO Information</b></br>
<img src="pics/2.png"><br>
<b>PXE DHCP Configuration</b></br>
<img src="pics/3.png"><br>
<b>PXE Admin Page</b></br>
<img src="pics/4.png"><br>
<b>PXE Message Page</b></br>
<img src="pics/5.png"><br>
<b>PXE Boot Page Generator</b></br>
<img src="pics/6.png"><br>
</center><br>
<pre>
NOTE : This program has been written for legal purposes. 
The author of this program is not responsible for illegal uses.
Required : PHP 7.2 and CentOS Linux

Default Username : alicangonullu
Default Password : 19742008
Default Token : 19742008
</pre>
<br>
