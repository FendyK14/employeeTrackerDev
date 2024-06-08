{ pkgs ? import <nixpkgs> {} }:

pkgs.mkShell {
  buildInputs = with pkgs; [
    php80
    nginx
    libmysqlclient
    php80Packages.composer
    nodejs_18
    npm
  ];

  shellHook = ''
    echo "Welcome to your Nix shell"
  '';
}
