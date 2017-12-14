module.exports = function (grunt) {
    // your tasks
    grunt.initConfig({
        "pkg": grunt.file.readJSON('package.json'),
        copy: {
            main: {
                files: [

                    {expand: true, cwd: 'node_modules', src: ['bootstrap/dist/css/bootstrap.css'], dest: 'public/css/', filter: 'isFile'},
                ],
            },
        },
    });

    // we use contrib-copy but many of others exists
    grunt.loadNpmTasks('grunt-contrib-copy');

    // here you can define several tasks name
    grunt.registerTask('default', ['copy']);
};
