FROM postgres:11.5
LABEL maintainer="Rémi Alvergnat <remi.alvergnat@gfi.fr>"

RUN apt-get update \
&& apt-get install -y --no-install-recommends postgresql \
&& rm -rf /var/lib/apt/lists/*

# Mount this volume to help loading/exporting dumps
RUN mkdir /workdir
VOLUME /workdir

# fixuid
ADD fixuid.tar.gz /usr/local/bin
RUN chown root:root /usr/local/bin/fixuid && \
    chmod 4755 /usr/local/bin/fixuid && \
    mkdir -p /etc/fixuid
COPY db/fixuid.yml /etc/fixuid/config.yml

USER postgres
