const posthtml = require('posthtml');

const styleToTailwind = () => {
    return (tree) => {
        tree.walk(node => {
            if (node.attrs && node.attrs.style) {
                const styles = node.attrs.style.split(';').reduce((acc, style) => {
                    const [property, value] = style.split(':').map(s => s.trim());
                    if (property && value) {
                        acc[property] = value;
                    }
                    return acc;
                }, {});

                // Mapping styles to Tailwind classes
                const classMap = {
                    'text-align': {
                        'center': 'text-center'
                    },
                    'background-color': {
                        '#e03e2d': 'bg-red-600'
                    }
                    // Thêm các mapping khác nếu cần thiết
                };

                node.attrs.class = node.attrs.class || '';
                Object.keys(styles).forEach(property => {
                    if (classMap[property] && classMap[property][styles[property]]) {
                        node.attrs.class += ` ${classMap[property][styles[property]]}`;
                        delete styles[property];
                    }
                });

                node.attrs.style = Object.keys(styles).map(property => `${property}: ${styles[property]}`).join('; ');
                if (!node.attrs.style) {
                    delete node.attrs.style;
                }
            }
            return node;
        });
    };
};

const content = process.argv[2];

posthtml()
    .use(styleToTailwind())
    .process(content)
    .then(result => {
        console.log(result.html);
    })
    .catch(error => {
        console.error(error);
        process.exit(1);
    });
