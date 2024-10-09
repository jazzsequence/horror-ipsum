const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText } = wp.blockEditor;

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

        const onChangeContent = (newContent) => {
            setAttributes({ content: newContent });
        };

        const generateRandomText = () => {
            const randomIndex = Math.floor(Math.random() * horrorTexts.length);
            setAttributes({ content: horrorTexts[randomIndex] });
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
            wp.element.createElement(
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
