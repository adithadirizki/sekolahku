const listMimeImg = ['image/png', 'image/jpeg'];
const listMimeAudio = ['audio/mpeg'];
const listMimeVideo = ['video/mp4'];
const listOtherMime = ['text/csv', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
var icons = Quill.import('ui/icons');
var BlockEmbed = Quill.import('blots/block/embed');
class AudioBlot extends BlockEmbed {
   static create(url) {
      let node = super.create();
      node.setAttribute('src', url);
      node.setAttribute('controls', true);
      node.setAttribute('controlsList', 'nodownload');
      return node;
   }
}
AudioBlot.blotName = 'audio';
AudioBlot.tagName = 'audio';
Quill.register(AudioBlot);
icons['file'] = feather.icons['upload'].toSvg();
icons['undo'] = feather.icons['corner-up-left'].toSvg();
icons['redo'] = feather.icons['corner-up-right'].toSvg();