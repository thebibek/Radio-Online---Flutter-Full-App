import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:google_mobile_ads/google_mobile_ads.dart';
import 'package:http/http.dart' as http;
import 'package:webview_flutter/webview_flutter.dart';

import 'Helper/Constant.dart';

///terms and condition class
class Terms extends StatefulWidget {
  @override
  _TermsState createState() => _TermsState();
}

class _TermsState extends State<Terms> {
  late String _privacy;
  String _loading = 'true';
  InterstitialAd? interstitialAd;
  bool adStatus=false;

  @override
  void initState() {
    super.initState();
    if (Platform.isAndroid) WebView.platform = SurfaceAndroidWebView();
    _createInterstitialAd();
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

  Future<bool> _onWillPop() async {
    if (adStatus)
      interstitialAd!.show();
    else
      Navigator.pop(context, true);
    return true;
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: _loadLocalHTML(),
      builder: (context, snapshot) {
        if (_loading.compareTo('true') == 0) {
          return Scaffold(
            appBar: AppBar(title: Text('Terms & Conditions'),centerTitle: true,),
            body: Center(child: CircularProgressIndicator()),
          );
        } else {
          return WillPopScope(
              onWillPop: _onWillPop,
              child:Scaffold(
              appBar: AppBar(title: Text('Terms & Conditions'),centerTitle: true,),
                  body:  WebView(
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
    var data = {
      'access_key': '6808',
    };
    var response = await http.post(terms_api, body: data);
    var getdata = json.decode(response.body);
    var error = getdata['error'].toString();
    if (error.compareTo('false') == 0) {
      setState(() {
        _loading = 'false';
         _privacy = getdata['data'].toString();
      });
    }
  }
}
