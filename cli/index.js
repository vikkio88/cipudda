const argv = require('minimist')(process.argv.slice(2));
const fs = require('fs');
const generateId = () => Math.random().toString(36).substr(2, 5);

const { title, f, key } = argv;
if (!(typeof title === 'string')) {
    console.log('No title specified --title');
    process.exit(-1);
}

if (!(typeof f === 'string')) {
    console.log('No file specified -f');
    process.exit(-1);
}

if (!(typeof key === 'string')) {
    console.log('No key specified --key');
    process.exit(-1);
}

if (!fs.existsSync(f)) {
    console.log(`File ${f} does not exist`);
    process.exit(-1);
}


const content = fs.readFileSync(f).toString();
const slug = `${title.toLocaleLowerCase().replace(/\s/g, '-')}-${generateId()}`;
console.log({ slug, title, content });