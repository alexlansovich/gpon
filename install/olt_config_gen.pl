#!/usr/bin/perl -w
################################
#### usage olt_config_gen.pl ip username password ####
use Expect;
use Fcntl;

$t=10;

$addr=$ARGV[0];
$username=$ARGV[1];
$password=$ARGV[2];
    $exp = new Expect();
    $exp->raw_pty(1);
    $exp->spawn("telnet $addr") ;
    $exp->expect($t, '-re','User name:');
    $exp->send("$username\r");
    $exp->expect($t,'-re','word:');
    $exp->send("$password\r");
    $exp->expect($t,'-re','>');
    $exp->send("enable\r");
    $exp->expect($t,'-re','#');
    $exp->send("config\r");
    $exp->expect($t,'-re','#');
    foreach $vlan_id (2100..3123)
    {
    ################################
    #### START add line-profile ####
    # с-вланы идут с 2100 по 3123 с 0 по 7-й слот
    # с-вланы идут с 2100 по 3123 с 8 по 15-й слот
    sleep 1;
    $exp->send("ont-lineprofile gpon profile-id $vlan_id profile-name vlan-$vlan_id\r");
    $exp->expect($t,'-re','#');
    sleep 1;
    $exp->send("tcont 1 dba-profile-id 10\r");
    $exp->expect($t,'-re','#');
    sleep 1;
    $exp->send("gem add 1 eth tcont 1\r\n");
    $exp->expect($t,'-re','#');
    sleep 1;
    $exp->send("gem mapping 1 1 vlan $vlan_id\r\n");
    $exp->expect($t,'-re','#');
    sleep 1;
    $exp->send("commit\r");
    $exp->expect($t,'-re','#');
    sleep 1;
    $exp->send("quit\r");
    $exp->expect($t,'-re','#');
    sleep 1;
    #### END of line profile ####
    }
    # quit config
    $exp->send("quit\r");
    $exp->expect($t,'-re','#');
    sleep 1;
    # quit olt
    $exp->send("quit\r");
    $exp->expect($t,'-re',':');
    # save olt config
    $exp->send("y\r");
$exp->soft_close();
