import 'dart:convert';
import 'package:assets_audio_player/assets_audio_player.dart';
import 'package:assets_audio_player/src/builders/player_builders_ext.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:http/http.dart' as http;
import 'All_Radio_Station.dart';
import 'Category.dart';
import 'Favorite.dart';
import 'Helper/Constant.dart';
import 'Helper/Favourite_Helper.dart';
import 'Helper/Model.dart';
import 'Helper/PushNotificationService.dart';
import 'Helper/bannerAds.dart';
import 'SubCategory.dart';
import 'main.dart';

///category list
List<Model> catList = [];

///current slider position
int _curSlider = 0;

///slider list
List<Model> slider_list = [];

///slider image list
List slider_image = [];

///favorite list size
int favSize = 0;

///is category loading
bool catloading = true;

///is error exist or not
bool errorExist = false;

///home class
class Home extends StatefulWidget {
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  @override
  Widget build(BuildContext context) {
    var shortestSide = MediaQuery.of(context).size.shortestSide;
    useMobileLayout = shortestSide < 600;

    return Scaffold(
      body: Padding(
          padding: const EdgeInsets.only(bottom: 200.0),
          child: Column(
            children: <Widget>[
              Expanded(
                child: SingleChildScrollView(
                  child: Padding(
                    padding: const EdgeInsets.only(top: 5, bottom: 4),
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: <Widget>[
                        CarouselWithIndicator(),
                        getLabel('Category'),
                        getCat(),
                        getLabel('Latest'),
                        getLatest(),
                        getFavorite(),
                      ],
                    ),
                  ),
                ),
              ),
              AdMobBanner()
            ],
          )),
    );
  }

  Future<void> getSlider() async {
    var data = {'access_key': '6808'};
    var response = await http.post(slider_api, body: data);
    var getdata = json.decode(response.body);
    print(getdata);
    if (!mounted) return null;
    setState(() {
      var error = getdata['error'].toString();

      if (error == 'false') {
        var data1 = (getdata['data']);

        slider_list = (data1 as List).map((data) => Model.fromJson(data as Map<String, dynamic>)).toList();
        for (var f in slider_list) {
          slider_image.add(f.image);
        }
      }
    });
  }
  @override
  void initState() {
    final pushNotificationService = PushNotificationService(context: context);
    pushNotificationService.initialise();
    getSlider();
    getCategory();
    callQuery();
    super.initState();
  }
  static final Favourite_Helper instance = Favourite_Helper.internal();
List<Model> favList=[];
  callQuery(){
    setState(() {
      instance.getAllFav().then((value) {
        favList.addAll(value);
        setState(() {});
      }
      );
    });
  }
  Widget getFavorite() {
    return  Padding(
            padding: const EdgeInsets.symmetric(horizontal: 10.0),
            child: FutureBuilder(
              builder: (context,AsyncSnapshot projectSnap /*projectSnap*/) {
                if (projectSnap.connectionState == ConnectionState.none ||
                    projectSnap.data == null) {
                  return Center(child: CircularProgressIndicator());
                } else {
                  favSize = int.parse(projectSnap.data!.length.toString());

                  return Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      favSize == 0
                          ? Container(
                              height: 0,
                            )
                          : getLabel('Favorites'),
                      Container(
                          height: favSize == 0 ? 10 : 150,
                          child: ListView.builder(
                              scrollDirection: Axis.horizontal,
                              physics: BouncingScrollPhysics(),
                              itemCount: int.parse(
                                  projectSnap.data.length.toString()) >
                                  0
                                  ? int.parse(projectSnap.data.length
                                  .toString()) >=
                                  10
                                  ? 10
                                  : int.parse(
                                  projectSnap.data.length.toString())
                                  : 0,
                              itemBuilder: (context, i) {
                                return InkWell(
                                  child: Column(
                                    children: <Widget>[
                                      Padding(
                                          padding: const EdgeInsets.all(8.0),
                                          child: Container(
                                              height: 100,
                                              width: 100,
                                              decoration: BoxDecoration(
                                                image: DecorationImage(
                                                    fit: BoxFit.cover,
                                                    image: NetworkImage(
                                                        '${projectSnap.data[i].image}')),
                                                borderRadius:
                                                BorderRadius.circular(5.0),
                                                boxShadow: [
                                                  BoxShadow(
                                                      color: Colors.black12,
                                                      offset: Offset(2, 2))
                                                ],
                                              ))),
                                      Container(
                                        width: 100,
                                        child: Padding(
                                          padding: EdgeInsets.all(3.0),
                                          child: Text(
                                            '${projectSnap.data[i].name}',
                                            maxLines: 1,
                                            overflow: TextOverflow.ellipsis,
                                          ),
                                        ),
                                        alignment: Alignment.center,
                                      ),
                                    ],
                                  ),
                                    onTap: () async {
                                      curPlayList = projectSnap.data as List<Model>?;
                                      audios.clear();
                                      await updateQueue(start: true,ind: i,choiceIndex: 1,context: context);
                                    }
                                );
                              })
                      )
                    ],
                  );
                }
              },
              future: db.getAllFav(),
            ),
          );
  }
/*  onTap: () async {
  curPlayList = projectSnap.data as List<Model>?;
  audios.clear();
  await updateQueue(start: true,ind: i,choiceIndex: 1);
},*/
  Future getCategory() async {
    var data = {
      'access_key': '6808',
    };
    var response = await http.post(cat_api, body: data);

    var getData = json.decode(response.body);

    var error = getData['error'].toString();

    setState(() {
      catloading = false;
      if (error == 'false') {
        var data1 = (getData['data']);
        catList = (data1 as List)
            .map((data) => Model.fromJson(data as Map<String, dynamic>))
            .toList();
      } else {
        errorExist = true;
      }
    });
  }

  Widget getLabel(String cls) {
    return Padding(
        padding: const EdgeInsets.symmetric(horizontal: 15.0, vertical: 5),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: <Widget>[
            Text(
              cls,
              style: Theme.of(context).textTheme.headline6,
            ),
            GestureDetector(
              child: Text(
                'See more',
                style: Theme.of(context).textTheme.caption!.copyWith(
                    color: primary, decoration: TextDecoration.underline),
              ),
              onTap: () {
                if (cls == 'Category') {
                  if (cityMode) {
                    catVisible = true;

                    Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) => SubCategory(
                                cityId: '', catId: "")));
                  } else
                    tabController!.animateTo(1);
                } else if (cls == 'Latest') {
                  tabController!.animateTo(2);
                } else if (cls == 'Favorites') {
                  Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => Favorite(),
                      ));
                }
              },
            ),
          ],
        ));
  }
  Widget getLatest() {
    var length = int.parse(radioList.length.toString());
    return Padding(
              padding: const EdgeInsets.symmetric(horizontal: 9.0),
              child: Container(
                  height: 131,
                  child: ListView.builder(
                      scrollDirection: Axis.horizontal,
                      physics: BouncingScrollPhysics(),
                      itemCount: length > 0
                          ? length > 10
                              ? 10
                              : length
                          : 0,
                      itemBuilder: (context, i) {
                        return InkWell(
                          child: Column(
                            children: <Widget>[
                              Padding(
                                  padding: const EdgeInsets.all(8.0),
                                  child: Container(
                                      height: 90,
                                      width: 90,
                                      decoration: BoxDecoration(
                                        image: DecorationImage(
                                            fit: BoxFit.cover,
                                            image: NetworkImage('${radioList[i].image}')),
                                        borderRadius:
                                            BorderRadius.circular(50.0),
                                        boxShadow: [
                                          BoxShadow()
                                        ],
                                      ))),
                              Container(
                                width: 100,
                                child: Padding(
                                  padding: EdgeInsets.all(3.0),
                                  child: Text(
                                    '${radioList[i].name}',
                                    maxLines: 1,
                                    overflow: TextOverflow.ellipsis,
                                  ),
                                ),
                                alignment: Alignment.center,
                              ),
                            ],
                          ),
                          onTap: () async {
                            curPlayList = radioList;
                              audios.clear();
                              await updateQueue(choiceIndex: 1,ind: i,start: true,context: context);
                          }
                        );
                      }
                      )
              )
          );

  }

  Widget getCat() {
    return Padding(
        padding: const EdgeInsets.symmetric(horizontal: 10.0),
        child: Container(
            height: 130,
            child: ListView.builder(
                scrollDirection: Axis.horizontal,
                physics: BouncingScrollPhysics(),
                itemCount: catList.isNotEmpty
                    ? catList.length > 10
                        ? 10
                        : catList.length
                    : 0,
                itemBuilder: (context, i) {
                  return InkWell(
                    child: Column(
                      children: <Widget>[
                        Padding(
                            padding: const EdgeInsets.all(7.0),
                            child: Container(
                                height: 90,
                                width: 90,
                                decoration: BoxDecoration(
                                  image: DecorationImage(
                                      fit: BoxFit.cover,
                                      image:
                                          NetworkImage('${catList[i].image}')),
                                  borderRadius: BorderRadius.circular(50.0),
                                  boxShadow: [
                                    BoxShadow(
                                        color: Colors.black12,
                                        offset: Offset(2, 2))
                                  ],
                                ))),
                        Container(
                          width: 100,
                          child: Padding(
                            padding: EdgeInsets.all(3.0),
                            child: Text(
                              '${catList[i].cat_name}',
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                            ),
                          ),
                          alignment: Alignment.center,
                        ),
                      ],
                    ),
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => SubCategory(
                                  cityId: "", catId: catList[i].id)));
                    },
                  );
                })));
  }
}

///coarousel slider
class CarouselWithIndicator extends StatefulWidget {
  @override
  _CarouselWithIndicatorState createState() => _CarouselWithIndicatorState();
}

class _CarouselWithIndicatorState extends State<CarouselWithIndicator> {

@override
void initState(){
  super.initState();
}
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        builder: (context, snapshot) {
          /*if (snapshot.connectionState != ConnectionState.active) {
            return SizedBox();
          }*/
          final running = snapshot.hasData;
          return slider_list.isEmpty
              ? Container(
                  padding: EdgeInsets.all(10),
                  child: Center(child: CircularProgressIndicator()),
                  height: 200,
                )
              : Stack(children: [
                  CarouselSlider(
                      items: getSlider(running) as List<Widget>,
                      options: CarouselOptions(
                        autoPlay: true,
                        enlargeCenterPage: true,
                        reverse: false,
                        autoPlayAnimationDuration: Duration(milliseconds: 1000),
                        aspectRatio: useMobileLayout ? 2.0 : 3.0,
                        onPageChanged: (index, reason) {
                          setState(() {
                            if (index < slider_list.length) {
                              _curSlider = index;
                            }
                          });
                        },
                      )),
                  Positioned.directional(
                    textDirection: direction,
                      bottom: 5,
                      end: 45,
                      width: MediaQuery.of(context).size.width,
                      child: Row(
                        mainAxisSize: MainAxisSize.max,
                        mainAxisAlignment: MainAxisAlignment.end,
                        children: <Widget>[
                          ConstrainedBox(
                            constraints: BoxConstraints(
                              minWidth: 5.0,
                              maxWidth: 200.0,
                            ),
                            child: DecoratedBox(
                              decoration: BoxDecoration(color: Colors.black45),
                              child: Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: Text(
                                  slider_list[_curSlider].name!,
                                  style: TextStyle(color: Colors.white),
                                ),
                              ),
                            ),
                          )
                        ],
                      )),
                 Positioned.directional(
                    textDirection: direction,
                      bottom: 5,
                      start: 60,
                      width: MediaQuery.of(context).size.width,
                      child: Row(
                        mainAxisSize: MainAxisSize.max,
                        mainAxisAlignment: MainAxisAlignment.start,
                        children: map<Widget>(
                          slider_list,
                          (index, url) {
                            return Container(
                              width: 8.0,
                              height: 8.0,
                              margin: EdgeInsets.symmetric(
                                  vertical: 10.0, horizontal: 2.0),
                              decoration: BoxDecoration(
                                  shape: BoxShape.circle,
                                  color: _curSlider == index
                                      ? Color.fromRGBO(0, 0, 0, 0.9)
                                      : Color.fromRGBO(0, 0, 0, 0.4)),
                            );
                          },
                        ).cast<Widget>().toList(),
                      )),
                ]);
        });
  }
  List<Widget>? getSlider(dynamic running) {
    return map<Widget>(
      slider_image,
      (index1, i) {
        return   assetsAudioPlayer.builderLoopMode(
            builder: (context, loopMode) {
          return PlayerBuilder.isPlaying(
            player: assetsAudioPlayer,
            builder: (context, isPlaying) { return GestureDetector(
          child: Container(
            margin: EdgeInsets.all(5.0),
            child: ClipRRect(
              borderRadius: BorderRadius.all(Radius.circular(5.0)),
              child: CachedNetworkImage(
                imageUrl: i.toString(),
                placeholder:(context, url) => Image.asset('assets/image/placeholder.png'),
                width: 1000.0,
                height: double.infinity,
                fit: BoxFit.fill,
              ),
            ),
          ),
          onTap: ()  async {
            setState(() {
              curPlayList = slider_list;
            });
            if (index1 < int.parse(curPlayList!.length.toString())) {
              audios.clear();
              updateQueue(choiceIndex: 1,start: true,ind: index1,context: context);
              /*await assetsAudioPlayer.open(
                Playlist(audios: audios,startIndex:index1 ),
                showNotification: true,notificationSettings:NotificationSettings(seekBarEnabled: false,),
                autoStart: true,forceOpen: true,
              );*/
             /* try {
                await assetsAudioPlayer.open(
                  Playlist(audios: audios,startIndex: index1),
                  autoStart: true,
                  showNotification: true,
                  playInBackground: PlayInBackground.enabled,
                  audioFocusStrategy: AudioFocusStrategy.request(
                      resumeAfterInterruption: true,
                      resumeOthersPlayersAfterDone: true),
                  headPhoneStrategy: HeadPhoneStrategy.pauseOnUnplug,
                  notificationSettings: NotificationSettings(
                  ),
                );
              } catch (e) {
                print(e);
              }*/
            }

          });
            });
            });
      },
    ).cast<Widget>().toList();
  }
}

List<T?> map<T>(List list, Function handler) {
  List<T?> result = [];
  for (var i = 0; i < list.length; i++) {
    result.add(handler(i, list[i]));
  }

  return result;
}
