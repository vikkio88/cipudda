import svelte from 'rollup-plugin-svelte';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import livereload from 'rollup-plugin-livereload';
import replace from 'rollup-plugin-replace';
import { terser } from 'rollup-plugin-terser';
import del from 'rollup-plugin-delete';
import copy from 'rollup-plugin-copy';
import html from 'rollup-plugin-bundle-html';
import dotenv from 'dotenv';


const randomHash = () => Math.random().toString(36).substr(2, 5);

const production = !process.env.ROLLUP_WATCH;
dotenv.config();

const hash = randomHash();

const output = !production ? {
	file: 'public/build/bundle.js'
} : {
		dir: 'dist',
		entryFileNames: 'bundle.[hash].js',
		assetFileNames: '[name].[hash].[ext]'
	};

export default {
	input: 'src/main.js',
	output: {
		sourcemap: !production,
		format: 'iife',
		name: 'app',
		...output
	},
	plugins: [
		del({ targets: ['dist/*', 'public/build/*'] }),

		svelte({
			dev: !production,
			css: css => {
				css.write(production ? `bundle.${hash}.css` : 'bundle.css', !production);
			}
		}),

		replace({
			process: JSON.stringify({
				env: {
					API_URL: process.env.API_URL
				}
			})
		}),

		resolve({
			browser: true,
			dedupe: importee => importee === 'svelte' || importee.startsWith('svelte/')
		}),
		commonjs(),
		!production && serve(),
		!production && livereload('public'),

		production && terser(),
		production && copy({
			targets: [
				{ src: 'public/style.css', dest: 'dist/', rename: `style.${hash}.css` },
			]
		}),
		production && html({
			template: 'public/index_prod.html',
			dest: "dist",
			filename: 'index.html',
			inject: 'head',
			/*
			externals: [
				{ type: 'css', file: `style.${hash}.css`, pos: 'before' },
				{ type: 'css', file: `bundle.${hash}.css`, pos: 'before' }
			]
			*/
		})
	],
	watch: {
		clearScreen: false
	}
};

function serve() {
	let started = false;

	return {
		writeBundle() {
			if (!started) {
				started = true;

				require('child_process').spawn('npm', ['run', 'start', '--', '--dev'], {
					stdio: ['ignore', 'inherit', 'inherit'],
					shell: true
				});
			}
		}
	};
}
