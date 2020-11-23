import svelte from 'rollup-plugin-svelte';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import livereload from 'rollup-plugin-livereload';
import replace from 'rollup-plugin-replace';
import { terser } from 'rollup-plugin-terser';
import del from 'rollup-plugin-delete';
import copy from 'rollup-plugin-copy';
import dotenv from 'dotenv';


const randomHash = () => Math.random().toString(36).substr(2, 5);

const production = !process.env.ROLLUP_WATCH;
dotenv.config();

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
			// enable run-time checks when not in production
			dev: !production,
			// we'll extract any component CSS out into
			// a separate file — better for performance
			css: css => {
				css.write(production ? `bundle.${randomHash()}.css` : 'bundle.css', !production);
			}
		}),

		replace({
			process: JSON.stringify({
				env: {
					API_URL: process.env.API_URL
				}
			})
		}),

		// If you have external dependencies installed from
		// npm, you'll most likely need these plugins. In
		// some cases you'll need additional configuration —
		// consult the documentation for details:
		// https://github.com/rollup/plugins/tree/master/packages/commonjs
		resolve({
			browser: true,
			dedupe: importee => importee === 'svelte' || importee.startsWith('svelte/')
		}),
		commonjs(),

		// In dev mode, call `npm run start` once
		// the bundle has been generated
		!production && serve(),

		// Watch the `public` directory and refresh the
		// browser on changes when not in production
		!production && livereload('public'),

		// If we're building for production (npm run build
		// instead of npm run dev), minify
		production && terser(),
		production && copy({
			targets: [
				{ src: 'public/index.html', dest: 'dist/' },
				{ src: 'public/style.css', dest: 'dist/', rename: `style.${randomHash()}.css` },
			]
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
