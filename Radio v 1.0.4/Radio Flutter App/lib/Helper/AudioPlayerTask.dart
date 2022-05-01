/*
import 'dart:async';
import 'package:audio_manager/audio_manager.dart';
import 'package:audio_service/audio_service.dart';
import 'package:flutter/material.dart';
import 'package:just_audio/just_audio.dart';
import 'package:rxdart/src/transformers/where_type.dart';
import 'package:rxdart/rxdart.dart';

import '../main.dart';
import 'Constant.dart';

class AudioPlayerHandler extends BaseAudioHandler with QueueHandler, SeekHandler {
  final BehaviorSubject<List<MediaItem>> _recentSubject = BehaviorSubject.seeded(<MediaItem>[]);
  AudioPlayer _player = new AudioPlayer();
   AudioProcessingState ?_skipState;
  List<MediaItem> _queue = [];
  List<MediaItem> get queueList => _queue;
  get index => _player.currentIndex;
  AudioPlayerHandler() {
    _init();
  }
  Future<void> _init() async {



    // Load and broadcast the queue
    queue.add(queueList);
    // For Android 11, record the most recent item so it can be resumed.
    mediaItem.whereType<MediaItem>().listen((item) => _recentSubject.add([item]));

    // Broadcast media item changes.
    _player.currentIndexStream.listen((index) {
      if(index==0) return;
      if (index != null) mediaItem.add(queueList[index]);
    });

    // Propagate all events from the audio player to AudioService clients.
    _player.playbackEventStream.listen(_broadcastState);

    // In this example, the service stops when reaching the end.
    _player.processingStateStream.listen((state) {
      switch (state) {
        case ProcessingState.completed:
          pause();
          break;
        case ProcessingState.loading:
          CircularProgressIndicator(color: Colors.white,);
          break;
        default:
          break;
      }


     */
/* if(state==ProcessingState.buffering)CircularProgressIndicator();
      if(state==ProcessingState.loading)CircularProgressIndicator();
      if (state == ProcessingState.completed) pause();*//*

    });
    try {
      await _player.setAudioSource(ConcatenatingAudioSource(
        children: queue.value
            .map((item) => AudioSource.uri(Uri.parse(item.id)))
            .toList(),

      ));
    } catch (e) {
      print(e);
    }
  }

  @override
  Future<List<MediaItem>> getChildren(String parentMediaId,
      [Map<String, dynamic>? options]) async {
    switch (parentMediaId) {
      case AudioService.recentRootId:
      // When the user resumes a media session, tell the system what the most
      // recently played item was.
        return _recentSubject.value;
      default:
      // Allow client to browse the media library.
        return queueList;
    }
  }

  @override
  Future<MediaItem?> getMediaItem(String mediaId) async {
    final newIndex = queueList.indexWhere((item) => item.id == mediaId);
    try {
      await _player.setAudioSource(
          ConcatenatingAudioSource(
            children: queueList
                .map((item) => AudioSource.uri(Uri.parse(item.id)))
                .toList(),
          ),
          initialIndex: newIndex);
      if (newIndex == index)
        await BaseAudioHandler().mediaItem;
    } catch (e) {
      print("Error: $e");
    }

   */
/* _skipState = (newIndex > index
        ? audioHandler!.skipToNext()
        : audioHandler!.skipToPrevious()) as AudioProcessingState?;*//*

    play();
  }
  @override
  Future<void> skipToQueueItem(int index) async {
    // Then default implementations of skipToNext and skipToPrevious provided by
    // the [QueueHandler] mixin will delegate to this method.
    if (index < 0 || index >= queue.value.length) return;
    // This jumps to the beginning of the queue item at newIndex.
    _player.seek(Duration.zero, index: index);
    // Demonstrate custom events.
    customEvent.add('skip to $index');
  }

  @override
  Future<void> play() => _player.play();

  @override
  Future<void> pause() => _player.pause();

  @override
  Future<void> seek(Duration position) => _player.seek(position);

  @override
  Future<void> stop() async {
    await _player.stop();
    await playbackState.firstWhere(
            (state) => state.processingState == AudioProcessingState.idle);
  }

  /// Broadcasts the current state to all clients.
  void _broadcastState(PlaybackEvent event) {
    final playing = _player.playing;
    playbackState.add(playbackState.value.copyWith(
      controls: [
        MediaControl.skipToPrevious,
        if (playing) MediaControl.pause else MediaControl.play,
        MediaControl.stop,
        MediaControl.skipToNext,
      ],
      systemActions: const {
        MediaAction.seek,
        MediaAction.seekForward,
        MediaAction.seekBackward,
      },
      androidCompactActionIndices: const [0, 1, 3],
      processingState: const {
        ProcessingState.idle: AudioProcessingState.idle,
        ProcessingState.loading: AudioProcessingState.loading,
        ProcessingState.buffering: AudioProcessingState.buffering,
        ProcessingState.ready: AudioProcessingState.ready,
        ProcessingState.completed: AudioProcessingState.completed,
      }[_player.processingState]!,
      playing: playing,
      updatePosition: _player.position,
      bufferedPosition: _player.bufferedPosition,
      speed: _player.speed,
      queueIndex: event.currentIndex,
    ));
  }
}
class MediaLibrary {
  static const albumsRootId = 'albums';

  final items = <String, List<MediaItem>>{
    AudioService.browsableRootId: const [
      MediaItem(
        id: albumsRootId,
        title: "Albums",
        playable: false,
      ),
    ],
    albumsRootId: [
      MediaItem(
        id: 'https://s3.amazonaws.com/scifri-episodes/scifri20181123-episode.mp3',
        album: "Science Friday",
        title: "A Salute To Head-Scratching Science",
        artist: "Science Friday and WNYC Studios",
        duration: const Duration(milliseconds: 5739820),
        artUri: Uri.parse(
            'https://media.wnyc.org/i/1400/1400/l/80/1/ScienceFriday_WNYCStudios_1400.jpg'),
      ),
      MediaItem(
        id: 'https://s3.amazonaws.com/scifri-segments/scifri201711241.mp3',
        album: "Science Friday",
        title: "From Cat Rheology To Operatic Incompetence",
        artist: "Science Friday and WNYC Studios",
        duration: const Duration(milliseconds: 2856950),
        artUri: Uri.parse(
            'https://media.wnyc.org/i/1400/1400/l/80/1/ScienceFriday_WNYCStudios_1400.jpg'),
      ),
    ],
  };
}

Stream<QueueState> get queueStateStream =>
    Rx.combineLatest2<List<MediaItem>?, MediaItem?, QueueState>(
        audioHandler!.queue,
        audioHandler!.mediaItem,
            (queue, mediaItem) => QueueState(queue, mediaItem));

class QueueState {
  final List<MediaItem>? queue;
  final MediaItem? mediaItem;

  QueueState(this.queue, this.mediaItem);
}

*/
