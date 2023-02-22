import Image from '@tiptap/extension-image';

export default Image.extend({
  name: 'customImage',

  addAttributes() {
    return {
      ...this.parent?.(),
      size: {
        default: 'small',
        parseHTML: element => element.getAttribute('data-size'),
        renderHTML: attributes => {
          return {
            'data-size': attributes.size,
            class: `custom-image-${attributes.size}`,
          };
        },
      },
      float: {
        default: 'center',
        parseHTML: element => element.getAttribute('data-float'),
        renderHTML: attributes => {
          return {
            'data-float': attributes.float,
            class: `custom-image-float-${attributes.float}`,
          };
        },
      },

    };
  },

  addCommands() {
    return {
      setImage: (options) => ({ tr, commands }) => {
        if (tr?.selection?.node?.type?.name === 'customImage') {
          return commands.updateAttributes('customImage', options);
        }

        return commands.insertContent({
          type: this.name,
          attrs: options,
        });
      },
    };
  },
});
