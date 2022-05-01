import 'package:assets_audio_player/assets_audio_player.dart';
import 'package:assets_audio_player/src/builders/player_builders_ext.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/scheduler.dart';
import 'Helper/Constant.dart';
///now playing bottom panel
class BottomPanel extends StatefulWidget {
  @override
  State<BottomPanel> createState() => _BottomPanelState();
}

class _BottomPanelState extends State<BottomPanel> {
  @override
  Widget build(BuildContext context) {
    return getBottomPanelLayout();
  }
 @override
 void initState(){
    super.initState();
 }
  ///bottom panel layout
  Widget getBottomPanelLayout() {
    return
     Directionality(textDirection: direction,
         child: Container(
        // Add box decoration
        decoration: getBackGradient(),
        child: curPlayList!.isNotEmpty ? getRowLayout() : Container()));
  }

  getBackGradient() {
    return BoxDecoration(
      // Box decoration takes a gradient
      gradient: LinearGradient(
        // Where the linear gradient begins and ends
        begin: Alignment.topLeft,
        end: Alignment.bottomRight,
        // Add one stop for each color. Stops should increase from 0 to 1
        stops: [0.2, 0.5, 0.9],
        colors: [
          secondary,
          primary.withOpacity(0.7),
          primary,
        ],
      ),
    );
  }
  Audio find(List<Audio> source, String fromPath) {
    return source.firstWhere((element) => element.path == fromPath);
  }
  getRowLayout() {
    return assetsAudioPlayer.builderCurrent(
        builder: (BuildContext context, Playing playing) {
          final myAudio = find(audios, playing.audio.assetAudioPath);
          return Row(
        children: <Widget>[
          Expanded(
            child: Row(
              children: <Widget>[
                Padding(
                  padding: EdgeInsets.only(right: 20, left: 10),
                  child: ClipRRect(
                      borderRadius: BorderRadius.circular(5),
                      child: FadeInImage(
                        placeholder:
                        AssetImage('assets/image/placeholder.png'),
                        image: NetworkImage(
                          myAudio.metas.image!.path,
                        ),
                        width: 50,
                        height: 50,
                        fit: BoxFit.cover,
                      )),
                ),
                Flexible(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Padding(
                        padding: const EdgeInsets.only(bottom: 8),
                        child: Text(
                          myAudio.metas.title! ,
                          overflow: TextOverflow.ellipsis,
                          style:
                          TextStyle(fontSize: 15, color: Colors.white),
                        ),
                      ),
                      MarqueeWidget(
                          direction: Axis.horizontal,
                          child: Text(
                            myAudio.metas.artist! ,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                fontSize: 11, color: Colors.white),
                          )),
                    ],
                  ),
                ),
              ],
            ),
          ),
          Material(
            color: Colors.transparent,
            child: Padding(
                padding: EdgeInsets.symmetric(horizontal: 15.0),
                child:  Column(children: <Widget>[
                  assetsAudioPlayer.builderLoopMode(
                    builder: (context, loopMode) {
                      return PlayerBuilder.isPlaying(
                          player: assetsAudioPlayer,
                          builder: (context, isPlaying) {
                            return Container(
                              padding: EdgeInsets.only(top: 7),
                                alignment: Alignment.topCenter,
                                child:  PlayerBuilder.isBuffering(
                                player: assetsAudioPlayer,
                                   builder: (context, isBuffering) {
                                  return isBuffering?Padding(
                                    padding: EdgeInsets.only(top: 8),
                                    child: CircularProgressIndicator(color: Colors.white,),
                                  ):IconButton(
                                  onPressed: () async {
                                    assetsAudioPlayer.playOrPause();
                                  },
                                  icon: Icon(
                                    isPlaying ? Icons.pause_circle_outline
                                        : Icons.play_circle_outline,
                                    size: 40.0,
                                    color: Colors.white,
                                  ),
                                );})
                            );
                          });
                    },
                  ),])

            ),

          ),
        ],
      );
  });
    }
  }


///current playing song name marquee
class MarqueeWidget extends StatefulWidget {
  final Widget? _child;
  final Axis? _direction;
  final Duration _animationDuration = const Duration(milliseconds: 3000),
      _backDuration = const Duration(milliseconds: 800),
      _pauseDuration = const Duration(milliseconds: 800);

  ///constructor
  MarqueeWidget({
    Widget? child,
    Axis? direction,
  })  : _child = child,
        _direction = direction;

  @override
  _MarqueeWidgetState createState() => _MarqueeWidgetState();
}

class _MarqueeWidgetState extends State<MarqueeWidget> {
  ScrollController _scrollController = ScrollController();

  @override
  void initState() {
    scroll();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: widget._child,
      scrollDirection: widget._direction!,
      controller: _scrollController,
    );
  }

  void scroll() async {
    //while (true) {
    if (!mounted) {
      return;
    }
    await Future.delayed(widget._pauseDuration);
    await _scrollController.animateTo(
        _scrollController.position.maxScrollExtent,
        duration: widget._animationDuration,
        curve: Curves.easeIn);

    await Future.delayed(widget._pauseDuration);
    SchedulerBinding.instance!.addPostFrameCallback((_) async {
      if (_scrollController.hasClients) {
        await _scrollController.animateTo(0.0,
            duration: widget._backDuration, curve: Curves.easeOut);
      }
    });
    //}
  }
}
