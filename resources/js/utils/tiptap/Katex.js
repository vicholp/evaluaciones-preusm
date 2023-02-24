import { Node } from '@tiptap/core';

export default Node.create({
  name: 'katex',

  addAttributes() {
    return {
      aa: {
        default: '',
        parseHTML: element => element.getAttribute('aa'),
        rendered: false,
      },

    };
  },

  addCommands() {
    return {
      setKatex: options => ({ commands }) => {
        // const node = this.type.create(attrs);

        // const transaction = state.tr.replaceSelectionWith(node);

        // dispatch(transaction);

        commands.insertContent({
          type: this.name,
          attrs: options,
        });
      },
    };
  },

  renderHTML({ HTMLAttributes }) {
    return ['lele', HTMLAttributes, 0];
  },
});
