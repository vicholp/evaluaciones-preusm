import { Node } from '@tiptap/core';
import Katex from './katexFromTiptap.vue';
import { VueNodeViewRenderer } from '@tiptap/vue-3';

export default Node.create({
  name: 'customKatex',

  group: 'inline',

  inline: true,

  atom: true,

  draggable: true,

  parseHTML() {
    return [
      {
        tag: 'katex',
      },
    ];
  },

  addAttributes() {
    return {
      formula: {
        default: '',
        parseHTML: element => element.getAttribute('data-expression'),
        renderHTML: attributes => {
          return {
            'data-expression': attributes.formula,
          };
        },
      },
    };
  },

  addNodeView() {
    return VueNodeViewRenderer(Katex);
  },

  addCommands() {
    return {
      setKatex: (attrs) => ({ commands, tr }) => {
        const offset = tr.selection.anchor;

        commands.insertContent([
          {
            type: 'customKatex',
            attrs,
          },
        ]);

        commands.setNodeSelection(offset);
      },
    };
  },

  renderHTML({ HTMLAttributes }) {
    return ['katex', HTMLAttributes];
  },
});
