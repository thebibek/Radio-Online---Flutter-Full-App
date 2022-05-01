import 'dart:async';
import 'dart:ui';
import 'package:assets_audio_player/assets_audio_player.dart' as pre;
import 'package:assets_audio_player/assets_audio_player.dart';
import 'package:flutter/cupertino.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'Model.dart';
import 'package:flutter/material.dart';
import 'dart:io';

//app general string

///app name for your app
String appname = 'Radio Online';

///package name of your app
String androidPackage = 'com.app.radioonline';

///ios bundle name
String iosPackage = 'iosPackage';

///app id android
const String AD_MOB_APP_ID = 'ca-app-pub-4894557581829964~2745494539';

///banner ad id android
const String AD_MOB_BANNER_ANDROID = 'ca-app-pub-3940256099942544/6300978111';

///Interstitial ad id android
const String AD_MOB_INSTER_ANDROID = 'ca-app-pub-3940256099942544/1033173712';

///app id ios
const String AD_MOB_APP_ID_IOS = 'ca-app-pub-4894557581829964~8311943097';

///banner ad id ios
const String AD_MOB_BANNER_IOS = 'ca-app-pub-3940256099942544/2934735716';

///Interstitial id ios
const String AD_MOB_INSTER_IOS = 'ca-app-pub-3940256099942544/4411468910';

///in all radio no of item, after which ad should be display
const int AD_AFTER_ITEM = 5;

///for rtl, ltr support change this to your value here
TextDirection direction = TextDirection.ltr;

///api url
String base_url = 'https://www.radio.wrteam.in/Api/';

///category api
Uri cat_api = Uri.parse('$base_url' 'get_categories');

///get station by category
Uri radio_bycat_api = Uri.parse('$base_url' 'get_radio_station_by_category');

///get radio station
Uri radio_station = Uri.parse('$base_url' 'get_radio_station');

///get report api
Uri report_api = Uri.parse('$base_url' 'radio_station_report');

///privacy policy api
Uri privacy_api = Uri.parse('$base_url' 'get_privacy_policy');

/// about us api
Uri about_api = Uri.parse('$base_url' 'get_about_us');

///terms and conditions api
Uri terms_api = Uri.parse('$base_url' 'get_terms_conditions');

///firebase token register api
Uri token_api = Uri.parse('$base_url' 'register_token');

///home page slider api
Uri slider_api = Uri.parse('$base_url' 'get_slider');

///search api
Uri search_api = Uri.parse('$base_url' 'search_station');

///city api
Uri city_api = Uri.parse('$base_url' 'get_city');

///city by id
Uri city_by_id = Uri.parse('$base_url' 'get_categories_by_city');

///get city mode
Uri city_mode = Uri.parse('$base_url' 'get_city_mode');

//color

///primary color of your app
Color primary = Color(0xffFD0262);

///secondary color of your app
Color secondary = Color(0xffFDBF92);

///common variable
late bool useMobileLayout;
bool cityMode = false;

///music player variable

List<Model>? curPlayList = [];
String? getBannerAdUnitId() {
  if (Platform.isIOS) {
    return AD_MOB_BANNER_IOS;
  } else if (Platform.isAndroid) {
    return AD_MOB_BANNER_ANDROID;
  }
  return null;
}
String? getInterstitialAdUnitId() {
  if (Platform.isIOS) {
    return AD_MOB_INSTER_IOS;
  } else if (Platform.isAndroid) {
    return AD_MOB_INSTER_ANDROID;
  }
  return null;
}

String? getAppId() {
  if (Platform.isIOS) {
    return AD_MOB_APP_ID_IOS;
  } else if (Platform.isAndroid) {
    return AD_MOB_APP_ID;
  }
  return null;
}

setPrefrenceBool(String key, bool value) async {
  SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setBool(key, value);
}

Future<bool> getPrefrenceBool(String key) async {
  SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getBool(key) ?? false;
}

final String ISFROMBACK = "isfrombackground$appname";
int index=0;
int favIndex=0;
String error="";
final List<StreamSubscription> subscriptions = [];
//_assetsAudioPlayer = AssetsAudioPlayer.newPlayer();
pre.AssetsAudioPlayer  assetsAudioPlayer = pre.AssetsAudioPlayer.withId('music');
final audios = <pre.Audio>[];
updateQueue({int ?ind,int ?choiceIndex,bool ?start,BuildContext ?context}) async {
  favIndex=ind!;
  print(curPlayList![ind].radio_url);
  for (int i = 0; i < curPlayList!.length; i++) {
    index = i;
    audios.add(pre.Audio.network(
      curPlayList![index].radio_url!,
      metas:pre. Metas(
        id: curPlayList![index].id!,
        title: curPlayList![index].name!,
        artist: curPlayList![index].description,
        album: '',
        image: pre.MetasImage.network(
            curPlayList![index].image!),
      ),
    ),
    );
  }
  try {
    assetsAudioPlayer.onErrorDo = (error) {
      error.player.stop();
    };
    await assetsAudioPlayer.open(
      pre.Playlist(audios: audios, startIndex: choiceIndex == 0 ? 0 : ind),
      showNotification: true,
      notificationSettings: pre.NotificationSettings(seekBarEnabled: false,),
      autoStart: start!,
    );
  }
  catch (t) {
    error=t.toString();
    print("error is .................>>>$error");
      ScaffoldMessenger.of(context!).showSnackBar(SnackBar(
        content: Text("Audio Not Available",
          textAlign: TextAlign.center,
        ),
        backgroundColor: primary,
        behavior: SnackBarBehavior.floating,
        elevation: 1.0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(50.0),
        ),
      ));
    await assetsAudioPlayer.open(
      pre.Playlist(audios: audios, startIndex: 0),
      showNotification: true,
      notificationSettings: pre.NotificationSettings(seekBarEnabled: false,),
      autoStart: false,
    );
  }
}


