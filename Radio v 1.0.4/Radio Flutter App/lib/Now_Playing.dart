import 'dart:convert';
import 'dart:io';
import 'dart:ui';
import 'package:assets_audio_player/assets_audio_player.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:http/http.dart' as http;
import 'package:share_plus/share_plus.dart';
import 'Helper/Constant.dart';
import 'main.dart';

final _text = TextEditingController();
bool _validate = false;

///now playing inside class
class NowPlaying extends StatefulWidget {
  final VoidCallback? _refresh;

  ///constructor
  NowPlaying({VoidCallback? refresh}) : _refresh = refresh;

  @override
  State<StatefulWidget> createState() {
    return _PlayerWidgetState();
  }
}

class _PlayerWidgetState extends State<NowPlaying> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(body: curPlayList!.isEmpty ? Container() : getContent());
  }

  getBackground() {
    return BoxDecoration(
      gradient: LinearGradient(
        begin: Alignment.topRight,
        end: Alignment.bottomCenter,
        stops: [0.4, 0.6, 0.8],
        colors: [
          Colors.white70,
          primary.withOpacity(0.5),
          secondary,
        ],
      ),
    );
  }
  Audio find(List<Audio> source, String fromPath) {
    return source.firstWhere((element) => element.path == fromPath);
  }
  getContent() {
    return  assetsAudioPlayer.builderCurrent(
        builder: (BuildContext context, Playing playing) {
          final myAudio = find(audios, playing.audio.assetAudioPath);
          return Container(
      decoration: getBackground(),
      height: MediaQuery.of(context).size.height,
      width: MediaQuery.of(context).size.width,
      child: Column(
              children: <Widget>[
                Container(
                  height: MediaQuery.of(context).size.height * .32,
                  child: Center(
                    child: ClipRRect(
                        borderRadius: BorderRadius.circular(10),
                        child: FadeInImage(
                          placeholder:
                              AssetImage('assets/image/placeholder.png'),
                          image: NetworkImage(
                            myAudio.metas.image!.path,
                            ),
                          width: 150,
                          height: 150,
                          fit: BoxFit.cover,
                        )),
                  ),
                ),
                Text(
                myAudio.metas.title! ,
                  style: Theme.of(context).textTheme.headline6,
                  textAlign: TextAlign.center,
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text(
                    myAudio.metas.artist! ,

                    style: Theme.of(context)
                        .textTheme
                        .subtitle1!
                        .copyWith(color: Colors.black45),
                    textAlign: TextAlign.center,
                  ),
                ),
                getMiddleButton(),
                getMediaButton()
              ],
            )

    );});
  }

  getMiddleButton() {
    return Padding(
      padding: const EdgeInsets.only(top: 16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        children: <Widget>[
          IconButton(
            icon: Icon(Icons.share),
            onPressed: () {
              if (Platform.isAndroid) {
                Share.share('I am listening to-\n'
                    '${curPlayList![index].title}\n'
                    '$appname\n'
                    'https://play.google.com/store/apps/details?id=$androidPackage&hl=en');
              } else {
                Share.share('I am listening to-\n'
                    '${curPlayList![index].title}\n'
                    '$appname\n'
                    '$iosPackage');
              }
            },
            color: Colors.white,
          ),
          FutureBuilder(
            builder: (context, snapshot) {
              if (snapshot.hasData) {
                return snapshot.data == true
                    ? IconButton(
                        icon: Icon(
                          Icons.favorite,
                          size: 30,
                          color: Colors.white,
                        ),
                        onPressed: () async {
                          await db.removeFav(curPlayList![favIndex].id);
                          if (!mounted) {
                            return;
                          }
                          setState(() {});
                          widget._refresh!();
                        })
                    : IconButton(
                        icon: Icon(
                          Icons.favorite_border,
                          size: 30,
                          color: Colors.white,
                        ),
                        onPressed: () async {
                          print("index in now playing is ......................$favIndex");
                          String? id, title, desc, img, url;
                            id = curPlayList![favIndex].id;
                            title = curPlayList![favIndex].name.toString();
                            desc = curPlayList![favIndex].description;
                            img = curPlayList![favIndex].image;
                            url = curPlayList![favIndex].radio_url;
                          await db.setFav(id, title, desc, img, url);
                          setState(() {});
                          widget._refresh!();
                        });
              } else {
                return Container();
              }
            },
            future: db.getFav(curPlayList![favIndex].id),
          ),
          IconButton(
            icon: Icon(Icons.queue_music),
            onPressed: () {
              panelController!.close();
            },
            color: Colors.white,
          ),
          IconButton(
            icon: Icon(Icons.report),
            onPressed: () {
              if (!mounted) {
                return;
              }
              setState(() {
                showDialog(
                    context: context,
                    builder: (_) {
                      return ReportDialog(mediaItem: curPlayList![index].id,);
                    });
              });
            },
            color: Colors.white,
          ),
        ],
      ),
    );
  }
  getMediaButton() {
    return assetsAudioPlayer.builderCurrent(
        builder: (BuildContext context, Playing playing) {
      return PlayerBuilder.isPlaying(
                player: assetsAudioPlayer,
                builder: (context, isPlaying) {
                  return  Container(
                    height: MediaQuery.of(context).size.height * 0.3,
                    child: Stack(
                      alignment: Alignment.center,
                      children: <Widget>[
                        Container(
                            decoration: BoxDecoration(
                              shape: BoxShape.rectangle,
                              color: primary.withOpacity(0.1),
                              borderRadius: BorderRadius.all(Radius.circular(20.0)),
                            ),
                            width: MediaQuery.of(context).size.width - 50,
                            child:
                            Column(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceAround,
                                  children: [
                                    IconButton(
                                        icon: Icon(Icons.fast_rewind),
                                        iconSize: 35.0,
                                        color: Colors.white,
                                        onPressed:(){
                                          setState(() {
                                            assetsAudioPlayer.previous();
                                          });
                                        }),
                                    IconButton(
                                        icon: Icon(Icons.fast_forward),
                                        iconSize: 35.0,
                                        color: Colors.white,
                                        onPressed:  () {
                                          setState(() {
                                            assetsAudioPlayer.next(stopIfLast: false);

                                          });
                                        }),
                                  ],
                                ),
                              ],
                            )),
                        Row(
                          mainAxisSize: MainAxisSize.min,
                          children: <Widget>[
                            Container(
                                decoration: BoxDecoration(
                                  boxShadow: [
                                    BoxShadow(color: Colors.white12, offset: Offset(2, 2))
                                  ],
                                  shape: BoxShape.circle,
                                  gradient: LinearGradient(
                                    begin: Alignment.topRight,
                                    end: Alignment.topLeft,
                                    stops: [0.2, 0.5, 0.9],
                                    colors: [
                                      Colors.deepOrange.withOpacity(0.5),
                                      primary.withOpacity(0.7),
                                      primary,
                                    ],
                                  ),
                                ),
                                child: Padding(
                                    padding: EdgeInsets.only(top: MediaQuery.of(context).size.height*.11,right: 15),
                                    child: Container(
                                        alignment: Alignment.topCenter,
                                        child: PlayerBuilder.isBuffering(
                                           player: assetsAudioPlayer,
                                           builder: (context, isBuffering) {
                                             return isBuffering?Container(
                                               alignment: Alignment.topCenter,
                                               padding: EdgeInsets.only(top: 12,left: 10),
                                               child: CircularProgressIndicator(color: Colors.white,),
                                           ):
                                        IconButton(
                                          onPressed: () async {
                                            assetsAudioPlayer.playOrPause();
                                            },
                                          icon: Icon(
                                            isPlaying ? Icons.pause : Icons.play_arrow,
                                            size: 48.0,
                                            color: Colors.white,
                                          ),
                                        );})

                                // if (playing)pauseButton(Icon(Icons.pause_circle_outline))
                                // else playButton(Icon(Icons.play_circle_outline)),

                            )


                          )),
            ],
          )
        ],
      ),
    );});});
  }
}

///report dialog
class ReportDialog extends StatefulWidget {
  final mediaItem;

  const ReportDialog({Key? key, this.mediaItem}) : super(key: key);

  @override
  _MyDialogState createState() => _MyDialogState();
}

class _MyDialogState extends State<ReportDialog> {
  @override
  Widget build(BuildContext context) {
    return CupertinoAlertDialog(
      title: Padding(
        padding: const EdgeInsets.only(bottom: 15.0),
        child: Text(
          'Report',
          style: TextStyle(
              fontWeight: FontWeight.bold, color: primary, fontSize: 20),
        ),
      ),
      content: Column(
        children: <Widget>[
          Text('Your issue with this radio will be checked.'),
          Padding(
            padding: const EdgeInsets.symmetric(vertical: 5, horizontal: 10),
            child: Material(
              color: Colors.transparent,
              child: TextField(
                controller: _text,
                decoration: InputDecoration(
                    hintText: 'Write your issue',
                    errorText: _validate ? 'Value Can\'t Be Empty' : null,
                    border: OutlineInputBorder()),
                maxLines: 5,
                keyboardType: TextInputType.multiline,
              ),
            ),
          ),
        ],
      ),
      actions: [
        CupertinoDialogAction(
            isDefaultAction: true,
            child: Text(
              'CANCEL',
              style: TextStyle(color: Colors.black),
            ),
            onPressed: () {
              _validate = false;
              Navigator.pop(context, 'Cancel');
            }),
        CupertinoDialogAction(
            isDefaultAction: true,
            child: Text(
              'SEND',
              style: TextStyle(color: Colors.black),
            ),
            onPressed: () {
              if (!mounted) {
                return;
              }
              setState(() {
                _text.text.isEmpty ? _validate = true : _validate = false;
                if (_validate == false) {
                  radioReport(
                       widget.mediaItem,
                      _text.text);
                  Navigator.pop(context, 'Cancel');
                }
              });
            }),
      ],
    );
  }

  Future<void> radioReport(String? station_id, String msg) async {
    print(station_id!+msg);
    var data = {
      'access_key': '6808',
      'radio_station_id': station_id.toString(),
      'message': msg
    };
    var response = await http.post(report_api, body: data);

    var getdata = json.decode(response.body);
    print(getdata);
    if(mounted) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text(
          'Your report submitted successfully',
          textAlign: TextAlign.center,
        ),
        backgroundColor: primary,
        behavior: SnackBarBehavior.floating,
        elevation: 1.0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(50.0),
        ),
      ));
    }
  }
}
