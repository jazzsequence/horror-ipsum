const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText } = wp.blockEditor;
const { useState } = wp.element;

const horrorTexts = horrorLipsumData.texts;

registerBlockType('horror-lorem-ipsum/random-paragraph', {
    title: 'Horror Lorem Ipsum',
    icon: 'admin-comments',
    category: 'widgets',
    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'p',
        },
    },
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes: { content }, setAttributes } = props;
        const [generated, setGenerated] = useState(false);

        const onChangeContent = (newContent) => {
            setAttributes({ content: newContent });
        };

        const generateRandomText = () => {
            let randomParagraph = '';
            for (let i = 0; i < 4; i++) {
                const randomIndex = Math.floor(Math.random() * horrorTexts.length);
                randomParagraph += horrorTexts[randomIndex] + ' ';
            }
            setAttributes({ content: randomParagraph.trim() });
            setGenerated(true);
        };

        return wp.element.createElement(
            'div',
            blockProps,
            wp.element.createElement(RichText, {
                tagName: 'p',
                value: content,
                onChange: onChangeContent,
                placeholder: 'Click the button to generate a random horror paragraph...',
            }),
            !generated && wp.element.createElement(
                'button',
                {
                    onClick: generateRandomText,
                    className: 'horror-lorem-ipsum-button',
                },
                'Generate Horror Text'
            )
        );
    },
    save: (props) => {
        const blockProps = useBlockProps.save();
        return wp.element.createElement(RichText.Content, {
            ...blockProps,
            tagName: 'p',
            value: props.attributes.content,
        });
    },
});
