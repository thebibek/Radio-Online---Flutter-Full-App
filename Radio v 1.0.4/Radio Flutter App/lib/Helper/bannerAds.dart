import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:google_mobile_ads/google_mobile_ads.dart';

import 'Constant.dart';

class AdMobBanner extends StatefulWidget {
  @override
  _AdMobBanner createState() => _AdMobBanner();
}

class _AdMobBanner extends State<AdMobBanner> {
  @override
  void initState() {
    _createAnchoredBanner();
    super.initState();
  }

  @override
  void dispose() {
    _anchoredBanner?.dispose();

    super.dispose();
  }

  String getBannerAdUnitId() {
    if (Platform.isIOS && !kIsWeb) {
      return AD_MOB_BANNER_IOS;
    } else if (Platform.isAndroid && !kIsWeb) {
      return AD_MOB_BANNER_ANDROID;
    }
    return "";
  }

  BannerAd? _anchoredBanner;
  Future<void> _createAnchoredBanner() async {
    final BannerAd banner = BannerAd(
      request: AdRequest(),
      adUnitId: getBannerAdUnitId(),
      listener: BannerAdListener(
        onAdLoaded: (Ad ad) {
          print('$BannerAd loaded');
          setState(() {
            _anchoredBanner = ad as BannerAd;
          });
        },
        onAdFailedToLoad: (Ad ad, LoadAdError error) {
          print('$BannerAd failedToLoad: $error');
        },
        onAdOpened: (Ad ad) => print('$BannerAd onAdOpened'),
        onAdClosed: (Ad ad) => print('$BannerAd onAdClosed'),
      ),
      size: AdSize.banner,
    );
    return banner.load();
  }

  @override
  Widget build(BuildContext context) {
    return _anchoredBanner != null
        ? Container(
      width: MediaQuery.of(context).size.width,
      height: _anchoredBanner!.size.height.toDouble(),
      child: AdWidget(ad: _anchoredBanner!),
    )
        : Container();
  }
}
