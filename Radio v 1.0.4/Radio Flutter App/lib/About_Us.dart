import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:google_mobile_ads/google_mobile_ads.dart';
import 'package:http/http.dart' as http;
import 'package:webview_flutter/webview_flutter.dart';

import 'Helper/Constant.dart';

class AboutUS extends StatefulWidget {
  @override
  _aboutState createState() => _aboutState();
}

class _aboutState extends State<AboutUS> {
  late String _privacy;
  String _loading = "true";
  InterstitialAd? interstitialAd;
  bool adStatus=false;
  @override
  void initState() {
    if (Platform.isAndroid) WebView.platform = SurfaceAndroidWebView();
    _createInterstitialAd();
    super.initState();
  }

  void _createInterstitialAd() {
    InterstitialAd.load(
        adUnitId: getInterstitialAdUnitId()!,
        request: AdRequest(),
        adLoadCallback: InterstitialAdLoadCallback(
          onAdLoaded: (InterstitialAd ad) {
            setState(() {
              interstitialAd = ad;
              adStatus=true;
            });
          },
          onAdFailedToLoad: (LoadAdError error) {
            print(error);
          },
        ));
  }
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: _loadLocalHTML(),
      builder: (context, snapshot) {
        if (_loading.compareTo('true') == 0) {
          return Scaffold(
            appBar: AppBar(
              title: Text('About Us'),
              centerTitle: true,
            ),
            body: Center(child: CircularProgressIndicator()),
          );
        } else {
          return WillPopScope(
              onWillPop: _onWillPop,
              child:Scaffold(
              appBar: AppBar(
              title: Text('About Us'),
                centerTitle: true,
              ),
                  body:WebView(
                    javascriptMode: JavascriptMode.unrestricted,
                    initialUrl: new Uri.dataFromString(_privacy, mimeType: 'text/html',encoding: utf8).toString(),
                  )
              )
          );
        }
      },
    );
  }

  Future _loadLocalHTML() async {
    Map data = {
      'access_key': "6808",
    };

    var response = await http.post(about_api, body: data);

    var getdata = json.decode(response.body);
    String error = getdata['error'].toString();
    if (error.compareTo('false') == 0) {
      if (mounted) {
        setState(() {
          _loading = 'false';
          _privacy = getdata['data'].toString();
        });
      }
    }
  }
  Future<bool> _onWillPop() async {
    if (adStatus)
      interstitialAd!.show();
    else
      Navigator.pop(context, true);
    return true;
  }
}
